<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16">

        {{-- Header Section --}}
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
                'tag_color' => 'text-emerald-700 bg-emerald-100 border border-emerald-200',
                'desc' => 'Lensa yang hanya memiliki satu titik fokus di seluruh permukaannya. Digunakan khusus untuk mengoreksi satu jenis gangguan penglihatan saja secara merata.',
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
                'tag_color' => 'text-amber-700 bg-amber-100 border border-amber-200',
                'desc' => 'Lensa dua fokus dengan batas bidang baca berbentuk lingkaran penuh di bagian bawah. Dirancang khusus untuk penderita presbiopia (mata tua).',
                'features' => [
                    'Jarak Jauh: Area bagian atas lensa utama',
                    'Jarak Dekat: Sisipan lingkaran (segmen bulat) di bawah',
                    'Sangat cocok untuk membaca buku/menulis',
                    'Garis pembatas segmen baca terlihat cukup jelas'
                ],
                'img' => asset('images/k2.png'),
                'icon' => '🔘'
            ],
            [
                'title' => 'Flattop Bifocal Lens',
                'alias' => 'Lensa Dua Fokus (Garis Lurus)',
                'tag' => 'Bidang Baca Luas',
                'tag_color' => 'text-blue-700 bg-blue-100 border border-blue-200',
                'desc' => 'Variasi lensa bifokal modern di mana segmen untuk penglihatan dekat memiliki potongan garis lurus mendatar di bagian atasnya.',
                'features' => [
                    'Transisi pandangan mata dekat terasa lebih stabil',
                    'Bidang pandang membaca lebih lebar dibanding Kryptok',
                    'Mengurangi efek lompatan gambar (image jump)',
                    'Estetika garis pembatas atas yang lebih rapi'
                ],
                'img' => asset('images/k3.png'),
                'icon' => '➖'
            ],
            [
                'title' => 'Progressive Lens',
                'alias' => 'Lensa Multi-Fokus Tanpa Batas',
                'tag' => 'Teknologi Premium',
                'tag_color' => 'text-purple-700 bg-purple-100 border border-purple-200',
                'desc' => 'Lensa mutakhir dengan koridor gradasi fokus yang halus dari atas ke bawah tanpa adanya garis pembatas yang terlihat sama sekali.',
                'features' => [
                    'Tiga Fokus sekaligus: Jauh, Menengah, dan Dekat',
                    'Kosmetik Sempurna: Terlihat seperti kacamata biasa',
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
                'tag_color' => 'text-orange-700 bg-orange-100 border border-orange-200',
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
                'tag_color' => 'text-indigo-700 bg-indigo-100 border border-indigo-200',
                'desc' => 'Lensa dengan lapisan khusus yang dirancang untuk memblokir paparan radiasi sinar biru (blue light) berbahaya dari layar gadget, laptop, dan TV.',
                'features' => [
                    'Menangkal kelelahan mata akibat menatap layar gawai',
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
                'tag' => 'Perlindungan Total',
                'tag_color' => 'text-rose-700 bg-rose-100 border border-rose-200',
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
                'tag_color' => 'text-slate-700 bg-slate-100 border border-slate-300',
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

        {{-- BAGIAN 1: LENSA KOREKTIF --}}
        <div class="space-y-6">
            <div class="border-l-4 border-cyan-500 pl-4">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">1. Kategori Lensa Korektif Refraksi</h2>
                <p class="text-slate-500 text-sm mt-1 font-medium">Dipilih berdasarkan diagnosis ketajaman atau jarak fokus penglihatan pasien.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                @foreach ($correctiveLenses as $lens)
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full group">
                    {{-- Area Gambar --}}
                    <div class="h-56 sm:h-64 bg-slate-50 relative overflow-hidden shrink-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent z-10 pointer-events-none"></div>
                        <img src="{{ $lens['img'] }}" alt="{{ $lens['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        <div class="absolute top-5 left-5 z-20">
                            <span class="text-[11px] font-black px-3.5 py-1.5 rounded-full shadow-sm backdrop-blur-md bg-white/95 uppercase tracking-wider {{ $lens['tag_color'] }}">
                                {{ $lens['tag'] }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- Area Konten --}}
                    <div class="p-6 sm:p-8 flex flex-col flex-grow">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-cyan-50 flex items-center justify-center shrink-0 border border-cyan-100">
                                <span class="text-2xl">{{ $lens['icon'] }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-tight">{{ $lens['title'] }}</h3>
                                <p class="text-sm font-bold text-cyan-600 mt-1">{{ $lens['alias'] }}</p>
                            </div>
                        </div>
                        
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            {{ $lens['desc'] }}
                        </p>
                        
                        {{-- Area Fitur (Di-push ke bawah dengan mt-auto agar kartu rata) --}}
                        <div class="mt-auto pt-5 border-t border-slate-100">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4">Karakteristik Struktur Utama</p>
                            <ul class="space-y-3">
                                @foreach ($lens['features'] as $feature)
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-cyan-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-slate-700 font-medium leading-snug">{{ $feature }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- BAGIAN 2: LAPISAN PROTEKSI --}}
        <div class="space-y-6">
            <div class="border-l-4 border-indigo-500 pl-4">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">2. Kategori Lapisan Proteksi (Coating)</h2>
                <p class="text-slate-500 text-sm mt-1 font-medium">Lapisan tambahan fungsional pada lensa minus/plus untuk kenyamanan aktivitas khusus.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                @foreach ($protectionLenses as $lens)
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full group">
                    {{-- Area Gambar --}}
                    <div class="h-56 sm:h-64 bg-slate-50 relative overflow-hidden shrink-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent z-10 pointer-events-none"></div>
                        <img src="{{ $lens['img'] }}" alt="{{ $lens['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        <div class="absolute top-5 left-5 z-20">
                            <span class="text-[11px] font-black px-3.5 py-1.5 rounded-full shadow-sm backdrop-blur-md bg-white/95 uppercase tracking-wider {{ $lens['tag_color'] }}">
                                {{ $lens['tag'] }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- Area Konten --}}
                    <div class="p-6 sm:p-8 flex flex-col flex-grow">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center shrink-0 border border-indigo-100">
                                <span class="text-2xl">{{ $lens['icon'] }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-tight">{{ $lens['title'] }}</h3>
                                <p class="text-sm font-bold text-indigo-600 mt-1">{{ $lens['alias'] }}</p>
                            </div>
                        </div>
                        
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            {{ $lens['desc'] }}
                        </p>
                        
                        {{-- Area Fitur (Di-push ke bawah dengan mt-auto agar kartu rata) --}}
                        <div class="mt-auto pt-5 border-t border-slate-100">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4">Manfaat Proteksi Ekstra</p>
                            <ul class="space-y-3">
                                @foreach ($lens['features'] as $feature)
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-indigo-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-slate-700 font-medium leading-snug">{{ $feature }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TIPS SECTION --}}
        <div class="bg-gradient-to-br from-slate-50 to-cyan-50/30 rounded-[2rem] border border-slate-200/60 p-6 sm:p-8 flex flex-col md:flex-row items-start md:items-center gap-6 shadow-sm">
            <div class="w-14 h-14 bg-gradient-to-br from-cyan-400 to-blue-600 text-white rounded-2xl flex items-center justify-center text-3xl shadow-lg shrink-0">
                💡
            </div>
            <div class="space-y-2">
                <h4 class="font-bold text-slate-900 text-lg">Tips Mengombinasikan Lensa Medis</h4>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Kombinasi terbaik saat ini untuk pekerja kantoran atau mahasiswa adalah menggabungkan struktur fokus <strong class="text-cyan-700">Single Vision</strong> atau <strong class="text-cyan-700">Progresif</strong> dengan lapisan proteksi <strong class="text-indigo-700">Bluecromic</strong>. Anda akan mendapatkan kacamata yang aman dari radiasi monitor sekaligus teduh saat berjalan di bawah terik matahari.
                </p>
                <div class="inline-flex items-start gap-2 bg-amber-50 text-amber-800 text-xs font-semibold p-3 rounded-xl border border-amber-100 mt-2">
                    <span class="shrink-0 text-amber-500">⚠️</span>
                    <p>Peringatan Klinis: Penggunaan lensa Night Drive yang berkualitas rendah pada siang hari dapat mengganggu persepsi warna alami Anda. Pastikan berkonsultasi dengan refraksionis optik mitra EyeExpert.</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 pt-6 pb-12 text-center relative">
        <div class="container mx-auto px-6 text-center">
                       <p class="text-slate-500 text-xs">© 2026 <strong>Sistem Pakar Pendeteksi Gangguan Mata</strong>. Dirancang untuk edukasi dan bantuan medis berbasis komputasi.</p>
        </div>
    </footer>
</x-app-layout>