<x-app-layout>
    {{-- ===================================================================
         HALAMAN PENYAKIT MATA
         Single-file Blade view. Modern, profesional, responsif.
         Toggle detail dikelola via Alpine.js (sudah bawaan Laravel Breeze/Jetstream).
         Jika belum ada Alpine, fallback <script> di bawah tetap berfungsi.
    ==================================================================== --}}
    @php
        // Data penyakit dipusatkan di satu tempat agar mudah dikelola.
        $penyakit = [
            ['judul' => 'Konjungtivitis',        'kategori' => 'Infeksi',   'desc' => 'Peradangan pada konjungtiva (selaput tipis mata) yang menyebabkan mata merah, berair, dan gatal. Penyebab utama adalah infeksi virus, bakteri, atau alergi.'],
            ['judul' => 'Katarak',               'kategori' => 'Degeneratif','desc' => 'Kekeruhan pada lensa mata yang menyebabkan penglihatan buram dan silau. Umumnya terjadi pada usia lanjut, tetapi bisa juga dipicu diabetes atau paparan UV.'],
            ['judul' => 'Glaukoma',              'kategori' => 'Saraf',     'desc' => 'Kerusakan saraf optik akibat tekanan bola mata meningkat. Penyakit ini dapat menyebabkan kebutaan permanen jika tidak ditangani sejak dini.'],
            ['judul' => 'Miopia',                'kategori' => 'Refraksi',  'desc' => 'Rabun jauh, di mana objek jauh terlihat buram. Disebabkan bentuk bola mata terlalu panjang atau kornea terlalu melengkung.'],
            ['judul' => 'Pterygium',             'kategori' => 'Pertumbuhan','desc' => 'Pertumbuhan jaringan pada konjungtiva yang dapat menutupi kornea. Penyebab utama adalah paparan sinar UV, debu, dan angin.'],
            ['judul' => 'Fotofobia',             'kategori' => 'Gejala',    'desc' => 'Sensitivitas berlebihan terhadap cahaya. Biasanya merupakan gejala infeksi mata, migrain, atau peradangan.'],
            ['judul' => 'Mata Kering',           'kategori' => 'Fungsional','desc' => 'Terjadi karena produksi air mata tidak cukup. Menyebabkan rasa perih, seperti berpasir, dan mata mudah lelah.'],
            ['judul' => 'Penglihatan Berkabut',  'kategori' => 'Gejala',    'desc' => 'Membuat objek terlihat buram seperti tertutup kabut. Penyebabnya bisa katarak awal atau gangguan refraksi.'],
            ['judul' => 'Astigmatisma',          'kategori' => 'Refraksi',  'desc' => 'Kelainan bentuk kornea yang tidak sempurna, menyebabkan penglihatan kabur di semua jarak.'],
            ['judul' => 'Diplopia',              'kategori' => 'Saraf',     'desc' => 'Kondisi melihat dua bayangan dari satu objek. Penyebabnya bisa gangguan saraf, otot mata, atau trauma kepala.'],
        ];
    @endphp

    <div class="min-h-screen bg-slate-50">
        <div class="max-w-6xl mx-auto px-4 py-8 space-y-8 sm:px-6 sm:py-12 sm:space-y-10">

            {{-- ============ HEADER ============ --}}
            <header class="text-center space-y-3">
                                <h1 class="text-3xl font-bold tracking-tight text-slate-900 text-balance sm:text-4xl md:text-5xl">
                    Penyakit Mata
                </h1>
                <p class="mx-auto max-w-xl text-sm text-slate-500 leading-relaxed text-pretty sm:text-base">
                    Pelajari berbagai gangguan penglihatan. Ketuk salah satu kartu di bawah untuk membaca penjelasan lengkapnya.
                </p>
            </header>

            {{-- ============ HERO IMAGE ============ --}}
            <div class="relative h-64 overflow-hidden rounded-2xl shadow-xl ring-1 ring-slate-200 sm:h-[360px] sm:rounded-3xl md:h-[460px]">
                <img src="{{ asset('images/penyakit.jpg') }}"
                     alt="Ilustrasi close-up mata manusia"
                     class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                <div class="absolute bottom-0 p-5 text-white sm:p-8">
                    <h2 class="text-xl font-semibold sm:text-2xl md:text-3xl">Kenali Sejak Dini</h2>
                    <p class="mt-1 max-w-md text-xs text-white/80 sm:text-sm">
                        Deteksi dini menjadi kunci untuk mencegah komplikasi penglihatan yang lebih serius.
                    </p>
                </div>
            </div>

            {{-- ============ INTRO ============ --}}
            <div class="rounded-2xl border border-teal-100 bg-teal-50/60 p-5 sm:p-6 md:p-8">
                <p class="text-sm leading-relaxed text-slate-700 sm:text-base">
                    Penyakit mata merupakan gangguan pada struktur atau fungsi organ penglihatan yang dapat disebabkan
                    oleh infeksi, faktor usia, kelainan refraksi, trauma, maupun penyakit sistemik seperti diabetes
                    dan hipertensi.
                </p>
            </div>

            {{-- ============ GRID PENYAKIT ============ --}}
            <div class="grid items-start gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($penyakit as $i => $item)
                    <div x-data="{ open: false }"
                         @click="open = !open"
                         class="group cursor-pointer self-start rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-teal-300 hover:shadow-lg">
                        <div class="flex items-start justify-between gap-3">
                            <div class="space-y-1">
                                <span class="text-xs font-medium uppercase tracking-wide text-teal-600">{{ $item['kategori'] }}</span>
                                <h3 class="text-lg font-semibold text-slate-900 group-hover:text-teal-700">{{ $item['judul'] }}</h3>
                            </div>
                            <span class="mt-1 flex h-7 w-7 flex-none items-center justify-center rounded-full bg-slate-100 text-slate-500 transition group-hover:bg-teal-100 group-hover:text-teal-700">
                                <svg class="h-4 w-4 transition-transform duration-300" :class="open && 'rotate-45'"
                                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                            </span>
                        </div>
                        <div x-show="open" x-collapse x-cloak class="mt-4 border-t border-slate-100 pt-4 text-sm leading-relaxed text-slate-600">
                            {{ $item['desc'] }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ============ WARNING ============ --}}
            <div class="flex items-start gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-5">
                <svg class="h-5 w-5 flex-none text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008M10.34 3.94l-8.4 14.56A1.5 1.5 0 003.24 21h17.52a1.5 1.5 0 001.3-2.5L13.66 3.94a1.5 1.5 0 00-2.6 0z"/>
                </svg>
                <p class="text-sm leading-relaxed text-amber-800">
                    Segera konsultasi ke dokter spesialis mata jika gejala semakin parah atau mengganggu penglihatan.
                    Informasi di halaman ini bersifat edukatif dan bukan pengganti diagnosis medis.
                </p>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 pt-6 pb-12 text-center relative">
        <div class="container mx-auto px-6 text-center">
                       <p class="text-slate-500 text-xs">© 2026 <strong>Sistem Pakar Pendeteksi Gangguan Mata</strong>. Dirancang untuk edukasi dan bantuan medis berbasis komputasi.</p>
        </div>
    </footer>
    
    {{-- x-cloak: sembunyikan elemen Alpine sebelum siap --}}
    <style>[x-cloak]{display:none!important}</style>

    {{-- Fallback toggle bila Alpine.js tidak tersedia di layout --}}
    <script>
        if (!window.Alpine) {
            document.querySelectorAll('[x-data]').forEach(function (card) {
                var detail = card.querySelector('[x-show]');
                var icon = card.querySelector('svg.transition-transform');
                if (detail) detail.style.display = 'none';
                card.addEventListener('click', function () {
                    var hidden = detail.style.display === 'none';
                    detail.style.display = hidden ? 'block' : 'none';
                    if (icon) icon.classList.toggle('rotate-45', hidden);
                });
            });
        }
    </script>

</x-app-layout>
