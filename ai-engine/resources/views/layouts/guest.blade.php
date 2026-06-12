<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EyeExpert') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/" class="flex flex-col items-center gap-3">
                    <div class="flex items-center gap-2 justify-center">
                        <div class="w-14 h-14 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200 hover:scale-105 transition-transform duration-300">
                            <i class="fa-solid fa-eye text-3xl"></i>
                        </div>
                        <span class="text-4xl font-extrabold tracking-tight text-indigo-900 hover:text-indigo-700 transition-colors">Eye<span class="text-indigo-600">Expert.</span></span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-6 py-4 bg-white shadow-xl shadow-slate-200/50 overflow-hidden sm:rounded-2xl border border-slate-100">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>