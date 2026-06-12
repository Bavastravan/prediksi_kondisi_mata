<section class="max-w-4xl mx-auto">
    <header class="mb-6">
        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
            Informasi Data Pasien
        </h2>
        <p class="mt-1.5 text-sm text-slate-500 leading-relaxed">
            Perbarui informasi profil dan rekam medis dasar Anda untuk keperluan akurasi diagnosa.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('patch')

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="shrink-0 relative group">
                <img id="preview-photo" class="h-20 w-20 sm:h-24 sm:w-24 object-cover rounded-full border-4 border-indigo-50 shadow-md transition-all duration-300 group-hover:border-indigo-100" 
                     src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=4f46e5&background=e0e7ff' }}" 
                     alt="Foto Profil" />
            </div>
            <div class="flex-1 w-full">
                <label for="photo" class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-50 border border-indigo-200 rounded-xl font-bold text-xs text-indigo-700 uppercase tracking-wider hover:bg-indigo-100 hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-200 transition-all cursor-pointer shadow-sm w-full sm:w-auto">
                    <i class="fa-solid fa-camera mr-2"></i> Pilih Foto Baru
                </label>
                <input type="file" name="photo" id="photo" accept="image/jpeg, image/png, image/jpg" onchange="previewProfileImage(event)" class="hidden"/>
                <p class="mt-2 text-[11px] sm:text-xs text-slate-500 italic">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
        </div>

        <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-100 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-5 sm:gap-x-6 sm:gap-y-6">
                
                <div class="col-span-1 sm:col-span-2 md:col-span-1">
                    <x-input-label for="name" value="Nama Lengkap" class="font-bold text-slate-700" />
                    <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="col-span-1 sm:col-span-2 md:col-span-1">
                    <x-input-label for="username" value="Username" class="font-bold text-slate-700" />
                    <x-text-input id="username" name="username" type="text" class="mt-1.5 block w-full bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm" :value="old('username', $user->username)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('username')" />
                </div>

                <div class="col-span-1 sm:col-span-2">
                    <x-input-label for="email" value="Alamat Email" class="font-bold text-slate-700" />
                    <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm" :value="old('email', $user->email)" required autocomplete="email" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="col-span-1">
                    <x-input-label for="phone" value="No. Telepon / WhatsApp" class="font-bold text-slate-700" />
                    <x-text-input id="phone" name="phone" type="tel" class="mt-1.5 block w-full bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm" :value="old('phone', $user->phone)" placeholder="081234567890" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <div class="col-span-1">
                    <x-input-label for="gender" value="Jenis Kelamin" class="font-bold text-slate-700" />
                    <select id="gender" name="gender" class="mt-1.5 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm bg-slate-50 text-sm text-slate-700">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                </div>

                <div class="col-span-1">
                    <x-input-label for="birth_place" value="Tempat Lahir" class="font-bold text-slate-700" />
                    <x-text-input id="birth_place" name="birth_place" type="text" class="mt-1.5 block w-full bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm" :value="old('birth_place', $user->birth_place)" placeholder="Contoh: Jakarta" />
                    <x-input-error class="mt-2" :messages="$errors->get('birth_place')" />
                </div>

                <div class="col-span-1">
                    <x-input-label for="birth_date" value="Tanggal Lahir" class="font-bold text-slate-700" />
                    <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1.5 block w-full bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm text-slate-700" :value="old('birth_date', $user->birth_date)" onchange="calculateAge()" />
                    <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                </div>

                <div class="col-span-1 sm:col-span-2">
                    <x-input-label for="age" value="Umur (Otomatis berdasarkan Tanggal Lahir)" class="font-bold text-slate-700" />
                    <div class="relative mt-1.5">
                        <x-text-input id="age" name="age" type="number" class="block w-full bg-slate-200 border-slate-200 text-slate-500 cursor-not-allowed rounded-xl shadow-inner text-sm font-bold" :value="old('age', $user->age)" readonly placeholder="-" />
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 text-sm font-bold">Tahun</span>
                        </div>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('age')" />
                </div>

            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-slate-200">
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-bold text-emerald-600 bg-emerald-50 px-4 py-2 rounded-xl border border-emerald-200 flex items-center w-full sm:w-auto justify-center">
                    <i class="fa-solid fa-circle-check mr-2"></i> Perubahan berhasil disimpan.
                </p>
            @else
                <div></div> @endif

            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3.5 bg-slate-900 border border-transparent rounded-xl font-bold text-sm text-white tracking-wide hover:bg-indigo-600 focus:bg-indigo-600 active:bg-indigo-800 transition-all duration-200 shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>

    <script>
        // Script untuk Preview Foto yang jauh lebih mulus
        function previewProfileImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview-photo');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.style.opacity = '0.5';
                    setTimeout(() => {
                        preview.src = e.target.result;
                        preview.style.opacity = '1';
                    }, 150);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Script untuk Hitung Umur Otomatis
        function calculateAge() {
            const birthDate = document.getElementById('birth_date').value;
            if (birthDate) {
                const today = new Date();
                const dob = new Date(birthDate);
                let age = today.getFullYear() - dob.getFullYear();
                const m = today.getMonth() - dob.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                // Cegah umur minus jika user iseng masukin tanggal masa depan
                document.getElementById('age').value = age >= 0 ? age : 0;
            } else {
                document.getElementById('age').value = '';
            }
        }
        
        // Kalkulasi awal saat halaman dimuat
        window.addEventListener('DOMContentLoaded', (event) => {
            calculateAge();
        });
    </script>
</section>