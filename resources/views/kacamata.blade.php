<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16">

        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-cyan-600 to-blue-700 text-white shadow-2xl p-8 sm:p-12">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
            <div class="relative z-10 max-w-3xl space-y-4">
                <span class="bg-cyan-500/30 text-cyan-200 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full backdrop-blur-sm">
                    Katalog Lensa & Lapisan Proteksi
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                    Mengenal Jenis Lensa & Lapisan Kacamata Medis
                </h1>
                <p class="text-cyan-100 text-base sm:text-lg leading-relaxed">
                    Setiap jenis lensa dirancang untuk kebutuhan refraksi yang berbeda, sementara lapisan protektif menjaga retina dari radiasi digital, sinar UV, hingga silau berkendara.
                </p>
            </div>
        </div>

        @php
        // 1. KATEGORI LENSA KOREKTIF (STRUKTUR FOKUS)
        $correctiveLenses = [
            [
                'title' => 'Single Vision Lens',
                'alias' => 'Lensa Fokus Tunggal',
                'tag' => 'Paling Populer',
                'tag_color' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'desc' => 'Lensa yang hanya memiliki satu titik fokus di seluruh permukaannya. Digunakan khusus untuk mengoreksi satu jenis gangguan penglihatan saja.',
                'features' => [
                    'Mengoreksi Rabun Jauh (Minus/Miopia)',
                    'Mengoreksi Rabun Dekat (Plus/Hipermetropia)',
                    'Mengoreksi Mata Silinder (Astigmatisme)',
                    'Ketebalan lensa merata di setiap area fokus'
                ],
                'img' => asset('images/k1.png'),
                'icon' => '🎯'
            ],
            [
                'title' => 'Kryptok Bifocal Lens',
                'alias' => 'Lensa Dua Fokus (Bulat)',
                'tag' => 'Klasik & Ergonomis',
                'tag_color' => 'bg-amber-100 text-amber-800 border-amber-200',
                'desc' => 'Lensa dua fokus dengan batas bidang baca berbentuk lingkaran penuh di bagian bawah. Dirancang untuk penderita presbiopia (mata tua).',
                'features' => [
                    'Jarak Jauh: Area bagian atas lensa utama',
                    'Jarak Dekat: Sisipan lingkaran (segmen bulat) di bawah',
                    'Sangat cocok untuk membaca buku/menulis',
                    'Garis pembatas segmen terlihat cukup jelas'
                ],
                'img' => asset('images/k2.png'),
                'icon' => '🔘'
            ],
            [
                'title' => 'Flattop Bifocal Lens',
                'alias' => 'Lensa Dua Fokus (Garis Lurus)',
                'tag' => 'Bidang Baca Luas',
                'tag_color' => 'bg-blue-100 text-blue-800 border-blue-200',
                'desc' => 'Variasi lensa bifokal modern di mana segmen untuk penglihatan dekat memiliki potongan garis lurus mendatar di bagian atasnya.',
                'features' => [
                    'Transisi pandangan mata dekat terasa lebih stabil',
                    'Bidang pandang membaca lebih lebar dibanding Kryptok',
                    'Mengurangi efek lompatan gambar (image jump)',
                    'Estetika garis pembatas atas yang rapi'
                ],
                'img' => asset('images/k3.png'),
                'icon' => '➖'
            ],
            [
                'title' => 'Progressive Lens',
                'alias' => 'Lensa Multi-Fokus Tanpa Batas',
                'tag' => 'Teknologi Premium',
                'tag_color' => 'bg-purple-100 text-purple-800 border-purple-200',
                'desc' => 'Lensa mutakhir dengan koridor gradasi fokus yang halus dari atas ke bawah tanpa ada garis pembatas sama sekali.',
                'features' => [
                    'Tiga Fokus sekaligus: Jauh, Menengah, dan Dekat',
                    'Kosmetik Sempurna: Terlihat seperti lensa biasa',
                    'Transisi fokus natural tanpa interupsi visual',
                    'Sangat direkomendasikan untuk pekerja digital aktif'
                ],
                'img' => asset('images/k4.JPEG'),
                'icon' => '⚡'
            ],
        ];

        // 2. KATEGORI LENSA COATING / PROTEKSI (FITUR SPESIFIK)
        $protectionLenses = [
            [
                'title' => 'Photochromic Lens',
                'alias' => 'Lensa Adaptif Sinar Matahari',
                'tag' => 'Outdoor Aktif',
                'tag_color' => 'bg-orange-100 text-orange-800 border-orange-200',
                'desc' => 'Lensa pintar yang dapat berubah warna menjadi gelap secara otomatis saat terkena sinar UV matahari dan kembali bening saat berada di dalam ruangan.',
                'features' => [
                    'Berubah gelap dalam hitungan detik di luar ruangan',
                    'Melindungi mata dari bahaya radiasi sinar UV penuh',
                    'Mengurangi mata silau dan tegang di siang hari',
                    'Berfungsi ganda sebagai kacamata hitam (sun glasses)'
                ],
                'img' => asset('images/k5.png'),
                'icon' => '☀️'
            ],
            [
                'title' => 'Anti-Blueray Lens',
                'alias' => 'Lensa Proteksi Radiasi Digital',
                'tag' => 'Wajib Pekerja IT',
                'tag_color' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                'desc' => 'Lensa dengan lapisan khusus yang dirancang untuk memblokir paparan radiasi sinar biru (blue light) berbahaya dari layar gadget, laptop, dan TV.',
                'features' => [
                    'Menangkal kelelahan mata akibat menatap layar lama',
                    'Mencegah risiko kerusakan jangka panjang pada retina',
                    'Membantu menjaga siklus tidur (melatonin) tetap baik',
                    'Memiliki refleksi lapisan coating kebiruan yang khas'
                ],
                'img' => asset('images/k6.png'),
                'icon' => '💻'
            ],
            [
                'title' => 'Bluecromic Lens',
                'alias' => 'Gabungan Anti-Blueray + Photochromic',
                'tag' => 'Perlindungan Total All-in-One',
                'tag_color' => 'bg-rose-100 text-rose-800 border-rose-200',
                'desc' => 'Teknologi lensa hibrida terbaik yang menggabungkan fitur anti-radiasi gawai dan kemampuan adaptasi gelap photochromic dalam satu lensa tunggal.',
                'features' => [
                    'Anti radiasi sinar biru saat bekerja di depan komputer',
                    'Otomatis berubah gelap saat beraktivitas di luar ruangan',
                    'Pilihan paling praktis untuk perlindungan dalam & luar ruang',
                    'Menjaga kenyamanan mata secara konstan sepanjang hari'
                ],
                'img' => asset('images/k7.jpeg'),
                'icon' => '🛡️'
            ],
            [
                'title' => 'Night Drive Lens',
                'alias' => 'Lensa Pengendara Malam (Anti Glare)',
                'tag' => 'Keamanan Berkendara',
                'tag_color' => 'bg-slate-100 text-slate-800 border-slate-200',
                'desc' => 'Lensa dengan lapisan anti-refleksi tingkat tinggi yang dikembangkan khusus untuk mengurangi efek silau lampu kendaraan dari arah berlawanan di malam hari.',
                'features' => [
                    'Meredam efek silau (glare) lampu LED kendaraan lawan',
                    'Meningkatkan kontras dan ketajaman pandangan malam hari',
                    'Mengurangi risiko kebutaan sesaat (flash blindness)',
                    'Sangat direkomendasikan untuk pengemudi jarak jauh'
                ],
                'img' => asset('images/k8.jpeg'),
                'icon' => '🌙'
            ],
        ];
        @endphp

        <div class="space-y-6">
            <div class="border-l-4 border-cyan-500 pl-4">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">1. Kategori Lensa Korektif Refraksi</h2>
                <p class="text-gray-500 text-sm">Dipilih berdasarkan diagnosis ketajaman atau jarak fokus penglihatan pasien.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach ($correctiveLenses as $lens)
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="h-52 bg-slate-50 relative overflow-hidden group">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 via-transparent to-transparent z-10"></div>
                            <img src="{{ $lens['img'] }}" alt="{{ $lens['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute top-4 left-4 z-20 flex gap-2">
                                <span class="text-xs font-semibold px-3 py-1 rounded-full border shadow-sm backdrop-blur-md bg-white/90 {{ $lens['tag_color'] }}">
                                    {{ $lens['tag'] }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8 space-y-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl">{{ $lens['icon'] }}</span>
                                    <h3 class="text-xl font-bold text-gray-900 tracking-tight">{{ $lens['title'] }}</h3>
                                </div>
                                <p class="text-sm font-semibold text-cyan-600">{{ $lens['alias'] }}</p>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $lens['desc'] }}</p>
                            <div class="pt-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Karakteristik Struktur</p>
                                <ul class="space-y-2">
                                    @foreach ($lens['features'] as $feature)
                                    <li class="flex items-start gap-3 text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-cyan-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>{{ $feature }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 sm:px-8 pb-6 pt-2">
                        <button onclick="alert('Simulasi fokus lensa {{ $lens['title'] }} sedang disiapkan.')" class="w-full bg-slate-50 hover:bg-cyan-500 text-gray-700 hover:text-white font-medium text-sm py-2.5 rounded-2xl border border-gray-200 hover:border-cyan-500 transition shadow-sm flex items-center justify-center gap-2">
                            Simulasi Fokus Lensa
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <div class="border-l-4 border-indigo-500 pl-4">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">2. Kategori Lapisan Proteksi (Coating) & Fitur</h2>
                <p class="text-gray-500 text-sm">Lapisan tambahan yang bisa dipasang pada lensa minus/plus untuk kenyamanan aktivitas khusus.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach ($protectionLenses as $lens)
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="h-52 bg-slate-50 relative overflow-hidden group">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 via-transparent to-transparent z-10"></div>
                            <img src="{{ $lens['img'] }}" alt="{{ $lens['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute top-4 left-4 z-20 flex gap-2">
                                <span class="text-xs font-semibold px-3 py-1 rounded-full border shadow-sm backdrop-blur-md bg-white/90 {{ $lens['tag_color'] }}">
                                    {{ $lens['tag'] }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8 space-y-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl">{{ $lens['icon'] }}</span>
                                    <h3 class="text-xl font-bold text-gray-900 tracking-tight">{{ $lens['title'] }}</h3>
                                </div>
                                <p class="text-sm font-semibold text-indigo-600">{{ $lens['alias'] }}</p>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $lens['desc'] }}</p>
                            <div class="pt-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Manfaat Proteksi</p>
                                <ul class="space-y-2">
                                    @foreach ($lens['features'] as $feature)
                                    <li class="flex items-start gap-3 text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-indigo-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>{{ $feature }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 sm:px-8 pb-6 pt-2">
                        <button onclick="alert('Simulasi proteksi filter {{ $lens['title'] }} sedang disiapkan.')" class="w-full bg-slate-50 hover:bg-indigo-500 text-gray-700 hover:text-white font-medium text-sm py-2.5 rounded-2xl border border-gray-200 hover:border-indigo-500 transition shadow-sm flex items-center justify-center gap-2">
                            Lihat Efek Filter Lapisan
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-gradient-to-br from-slate-50 to-cyan-50/30 rounded-3xl border border-slate-200/60 p-6 sm:p-8 flex flex-col md:flex-row items-center gap-6">
            <div class="p-4 bg-cyan-500 text-white rounded-2xl text-3xl shadow-md shrink-0">
                💡
            </div>
            <div class="space-y-2">
                <h4 class="font-bold text-gray-900 text-lg">Tips Mengombinasikan Lensa Medis</h4>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Kombinasi terbaik saat ini untuk pekerja kantoran atau mahasiswa adalah menggabungkan struktur fokus <strong>Single Vision</strong> atau <strong>Progresif</strong> dengan lapisan proteksi <strong>Bluecromic</strong>. Anda akan mendapatkan kacamata yang aman dari radiasi monitor sekaligus teduh saat berjalan di bawah terik matahari.
                </p>
                <p class="text-xs text-amber-600 font-semibold pt-1">
                    ⚠️ Peringatan Klinis: Penggunaan lensa Night Drive yang berkualitas rendah pada siang hari dapat mengganggu persepsi warna alami Anda. Pastikan berkonsultasi dengan refraksionis optik mitra EyeExpert.
                </p>
            </div>
        </div>

    </div>
</x-app-layout>