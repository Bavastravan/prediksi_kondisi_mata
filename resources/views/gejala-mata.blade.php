<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="max-w-6xl mx-auto px-4 py-8 space-y-8 sm:px-6 sm:py-12 sm:space-y-10">

            {{-- ============ HEADER ============ --}}
            <header class="text-center space-y-3">
                
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 text-balance sm:text-4xl md:text-5xl">
                    Gejala Penyakit Mata
                </h1>
                <p class="mx-auto max-w-xl text-sm text-slate-500 leading-relaxed text-pretty sm:text-base">
                    Kenali tanda-tanda gangguan penglihatan. Ketuk salah satu kartu untuk membaca penjelasan medis lengkapnya.
                </p>
            </header>

            {{-- ============ HERO IMAGE ============ --}}
            <div class="relative h-64 overflow-hidden rounded-2xl shadow-xl ring-1 ring-slate-200 sm:h-[360px] sm:rounded-3xl md:h-[460px]">
                <img src="{{ asset('images/gejala.jpg') }}"
                     alt="Ilustrasi gejala penyakit mata"
                     class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                <div class="absolute bottom-0 p-5 text-white sm:p-8">
                    <h2 class="text-xl font-semibold sm:text-2xl md:text-3xl">Perhatikan Tanda Awal</h2>
                    <p class="mt-1 max-w-md text-xs text-white/80 sm:text-sm">
                        Mengenali gejala secara dini membantu mencegah penurunan fungsi penglihatan permanen.
                    </p>
                </div>
            </div>

            {{-- ============ INTRO ============ --}}
            <div class="rounded-2xl border border-teal-100 bg-teal-50/60 p-5 sm:p-6 md:p-8">
                <p class="text-sm leading-relaxed text-slate-700 sm:text-base">
                    Gejala mata merupakan manifestasi klinis dari gangguan pada struktur atau fungsi organ penglihatan.
                    Gejala ini dapat berkaitan dengan infeksi, kelainan refraksi, gangguan saraf, hingga penyakit
                    degeneratif. Deteksi dini sangat penting untuk mencegah penurunan fungsi penglihatan permanen.
                </p>
            </div>

            {{-- ============ GRID GEJALA ============ --}}
            @php
                $gejala = [
                    [
                        'kategori' => 'Infeksi',
                        'judul'    => 'Hiperemia Konjungtiva',
                        'ringkas'  => 'Kemerahan pada bagian putih mata.',
                        'deskripsi' => [
                            'Hiperemia konjungtiva adalah kondisi pelebaran pembuluh darah pada konjungtiva, yaitu membran tipis yang melapisi bagian putih mata dan kelopak mata bagian dalam.',
                            'Kondisi ini menyebabkan mata tampak merah secara menyeluruh atau lokal, dan sering disertai rasa tidak nyaman seperti perih atau sensasi panas ringan.',
                        ],
                        'label'    => 'Penyebab utama:',
                        'poin'     => [
                            'Iritasi lingkungan seperti debu, asap, dan polusi udara',
                            'Infeksi virus (conjunctivitis viral) atau bakteri',
                            'Reaksi alergi terhadap debu, serbuk sari, atau kosmetik',
                            'Kelelahan mata akibat penggunaan layar berlebihan',
                        ],
                    ],
                    [
                        'kategori' => 'Refraksi',
                        'judul'    => 'Penurunan Visus',
                        'ringkas'  => 'Menurunnya ketajaman penglihatan.',
                        'deskripsi' => [
                            'Penurunan visus merupakan kondisi ketika kemampuan mata dalam menangkap dan memfokuskan objek mengalami penurunan, sehingga objek terlihat buram atau tidak jelas.',
                            'Kondisi ini dapat terjadi secara bertahap maupun mendadak tergantung penyebab yang mendasari.',
                        ],
                        'label'    => 'Penyebab umum:',
                        'poin'     => [
                            'Kelainan refraksi (miopia, hipermetropi, astigmatisma)',
                            'Katarak yang menyebabkan lensa mata menjadi keruh',
                            'Gangguan retina atau saraf optik',
                            'Komplikasi penyakit sistemik seperti diabetes (retinopati diabetik)',
                        ],
                    ],
                    [
                        'kategori' => 'Saraf',
                        'judul'    => 'Fotofobia',
                        'ringkas'  => 'Sensitivitas cahaya berlebihan.',
                        'deskripsi' => [
                            'Fotofobia adalah kondisi meningkatnya sensitivitas mata terhadap cahaya, yang menyebabkan ketidaknyamanan hingga rasa nyeri saat terpapar cahaya terang.',
                            'Kondisi ini bukan penyakit utama, melainkan gejala dari gangguan lain pada mata atau sistem saraf.',
                        ],
                        'label'    => 'Penyebab:',
                        'poin'     => [
                            'Infeksi kornea (keratitis)',
                            'Uveitis atau peradangan bagian dalam mata',
                            'Migrain atau gangguan neurologis',
                            'Mata kering kronis',
                        ],
                    ],
                    [
                        'kategori' => 'Struktural',
                        'judul'    => 'Indikasi Selaput',
                        'ringkas'  => 'Pertumbuhan jaringan atau kekeruhan.',
                        'deskripsi' => [
                            'Indikasi selaput menggambarkan adanya pertumbuhan jaringan abnormal atau kekeruhan pada struktur optik mata yang dapat mengganggu jalur masuk cahaya.',
                        ],
                        'label'    => 'Kondisi terkait:',
                        'poin'     => [
                            'Pterygium: pertumbuhan jaringan pada konjungtiva yang dapat menutupi kornea',
                            'Katarak: kekeruhan pada lensa mata yang menghambat cahaya masuk',
                        ],
                    ],
                    [
                        'kategori' => 'Lakrimal',
                        'judul'    => 'Mata Berair',
                        'ringkas'  => 'Produksi air mata berlebihan.',
                        'deskripsi' => [
                            'Mata berair atau epiphora adalah kondisi produksi air mata yang berlebihan atau tidak dapat dialirkan dengan normal melalui saluran lakrimal.',
                        ],
                        'label'    => 'Penyebab:',
                        'poin'     => [
                            'Iritasi akibat debu, asap, atau benda asing',
                            'Alergi mata',
                            'Sumbatan saluran air mata',
                            'Infeksi pada sistem lakrimal',
                        ],
                    ],
                    [
                        'kategori' => 'Alergi',
                        'judul'    => 'Mata Gatal',
                        'ringkas'  => 'Sensasi ingin menggaruk mata.',
                        'deskripsi' => [
                            'Mata gatal merupakan sensasi tidak nyaman pada permukaan mata yang sering memicu keinginan untuk menggosok atau menggaruk mata.',
                        ],
                        'label'    => 'Penyebab:',
                        'poin'     => [
                            'Reaksi alergi (serbuk sari, debu, bulu hewan)',
                            'Infeksi ringan pada konjungtiva',
                            'Mata kering',
                            'Iritasi akibat penggunaan lensa kontak',
                        ],
                    ],
                    [
                        'kategori' => 'Fungsional',
                        'judul'    => 'Mata Lelah',
                        'ringkas'  => 'Kelelahan visual akibat aktivitas.',
                        'deskripsi' => [
                            'Mata lelah atau asthenopia adalah kondisi kelelahan otot mata akibat penggunaan visual yang berlebihan dalam jangka waktu lama.',
                        ],
                        'label'    => 'Penyebab:',
                        'poin'     => [
                            'Menatap layar gadget terlalu lama',
                            'Pencahayaan yang tidak sesuai',
                            'Kurang istirahat mata',
                            'Gangguan refraksi yang tidak dikoreksi',
                        ],
                    ],
                    [
                        'kategori' => 'Degeneratif',
                        'judul'    => 'Penglihatan Berkabut',
                        'ringkas'  => 'Pandangan seperti tertutup kabut.',
                        'deskripsi' => [
                            'Penglihatan berkabut adalah kondisi di mana objek terlihat tidak jelas, seolah tertutup lapisan kabut atau film tipis.',
                        ],
                        'label'    => 'Penyebab:',
                        'poin'     => [
                            'Katarak stadium awal',
                            'Mata kering kronis',
                            'Gangguan refraksi yang tidak dikoreksi',
                            'Edema kornea',
                        ],
                    ],
                    [
                        'kategori' => 'Lakrimal',
                        'judul'    => 'Mata Kering',
                        'ringkas'  => 'Kurangnya pelumasan permukaan mata.',
                        'deskripsi' => [
                            'Mata kering adalah kondisi ketika produksi air mata tidak cukup untuk menjaga kelembapan permukaan mata.',
                        ],
                        'label'    => 'Penyebab:',
                        'poin'     => [
                            'Penggunaan komputer terlalu lama',
                            'Usia lanjut',
                            'Lingkungan kering atau ber-AC',
                        ],
                    ],
                    [
                        'kategori' => 'Saraf',
                        'judul'    => 'Penglihatan Ganda',
                        'ringkas'  => 'Melihat satu objek menjadi dua.',
                        'deskripsi' => [
                            'Penglihatan ganda (diplopia) adalah kondisi ketika seseorang melihat dua bayangan dari satu objek yang sama.',
                        ],
                        'label'    => 'Penyebab:',
                        'poin'     => [
                            'Gangguan otot mata',
                            'Kelainan saraf kranial',
                            'Trauma kepala atau mata',
                        ],
                    ],
                ];
            @endphp

            <div class="grid items-start gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($gejala as $item)
                    <div x-data="{ open: false }"
                         @click="open = !open"
                         class="group cursor-pointer self-start rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-teal-300 hover:shadow-lg">

                        {{-- Header kartu --}}
                        <div class="flex items-start justify-between gap-3">
                            <div class="space-y-1">
                                <span class="text-xs font-semibold uppercase tracking-wide text-teal-600">
                                    {{ $item['kategori'] }}
                                </span>
                                <h3 class="text-lg font-semibold text-slate-900">{{ $item['judul'] }}</h3>
                            </div>
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-500 transition group-hover:bg-teal-100 group-hover:text-teal-600">
                                <svg x-show="!open" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                <svg x-show="open" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                            </span>
                        </div>

                        <p class="mt-2 text-sm text-slate-500">{{ $item['ringkas'] }}</p>

                        {{-- Detail --}}
                        <div x-show="open" x-collapse x-cloak class="mt-4 space-y-3 border-t border-slate-100 pt-4 text-sm leading-relaxed text-slate-600">
                            @foreach ($item['deskripsi'] as $paragraf)
                                <p>{{ $paragraf }}</p>
                            @endforeach
                            <p class="font-semibold text-slate-800">{{ $item['label'] }}</p>
                            <ul class="space-y-1.5">
                                @foreach ($item['poin'] as $poin)
                                    <li class="flex gap-2">
                                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-teal-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                        </svg>
                                        <span>{{ $poin }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ============ DISCLAIMER ============ --}}
            <div class="flex items-start gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 sm:p-5">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                <p class="text-xs leading-relaxed text-amber-800 sm:text-sm">
                    Informasi ini bersifat edukatif dan bukan pengganti diagnosis medis. Jika mengalami gejala yang
                    mengganggu atau menetap, segera konsultasikan dengan dokter spesialis mata.
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

    {{-- Fallback bila Alpine.js tidak tersedia --}}
    <style>[x-cloak]{display:none!important}</style>
    <script>
        if (typeof window.Alpine === 'undefined') {
            document.addEventListener('click', function (e) {
                var card = e.target.closest('[x-data]');
                if (!card) return;
                var detail = card.querySelector('[x-show]');
                if (detail) detail.classList.toggle('hidden');
            });
            document.querySelectorAll('[x-show]').forEach(function (el) { el.classList.add('hidden'); });
        }
    </script>
</x-app-layout>