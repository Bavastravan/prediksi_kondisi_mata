<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk request login.
     */
    public function rules(): array
    {
        return [
            // Kita ganti 'email' menjadi 'login' agar lebih universal
            'login' => ['required', 'string'], 
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Mencoba melakukan autentikasi kredensial.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Logika deteksi: Apakah input 'login' merupakan email atau username?
        $loginValue = $this->input('login');
        $fieldType = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Susun kredensial berdasarkan tipe field yang terdeteksi
        $credentials = [
            $fieldType => $loginValue,
            'password' => $this->input('password'),
        ];

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Memastikan request tidak terkena rate limit (pembatasan percobaan).
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Mendapatkan key untuk throttle rate limiting.
     */
    public function throttleKey(): string
    {
        // Menggunakan input 'login' sebagai identifier unik per IP
        return Str::transliterate(Str::lower($this->string('login')).'|'.$this->ip());
    }
}