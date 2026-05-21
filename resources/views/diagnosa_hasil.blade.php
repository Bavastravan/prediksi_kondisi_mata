<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                
                @php
                    // Normalisasi class untuk pengecekan
                    $kelasHasil = $class ?? 'Data Inputan Gagal Terdiagnosa';
                    $isGagal = str_contains($kelasHasil, 'Gagal') || str_contains($kelasHasil, 'Bukan Mata');
                    
                    // Setup Header Warna & Ikon
                    $headerBg = 'from-slate-800 to-slate-900'; 
                    $headerIcon = 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z';

                    if ($isGagal) {
                        $headerBg = 'from-amber-500 to-amber-600';
                        $headerIcon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                    } elseif (str_contains($kelasHasil, 'Normal') || str_contains($kelasHasil, 'Sehat')) {
                        $headerBg = 'from-emerald-500 to-emerald-600';
                        $headerIcon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                    } elseif (str_contains($kelasHasil, 'Refraksi')) {
                        $headerBg = 'from-blue-500 to-blue-600';
                        $headerIcon = 'M15 12a3 3 0 11-6 0 3 3 0 016 0z';
                    } else {
                        // Penyakit (Katarak, Uveitis, Belekan, Bintitan, dll)
                        $headerBg = 'from-rose-500 to-rose-600';
                        $headerIcon = 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z';
                    }

                    // Setup Rekomendasi Kacamata Terintegrasi
                    $rekomendasiKacamata = null;
                    if ($kelasHasil === 'Katarak') {
                        $rekomendasiKacamata = ['title' => 'Photochromic / Bluecromic Lens', 'desc' => 'Melindungi kornea dari radiasi UV matahari yang dapat mempercepat penebalan katarak, serta meredam efek silau yang menyakitkan.', 'icon' => '☀️', 'color' => 'amber'];
                    } elseif (str_contains($kelasHasil, 'Refraksi')) {
                        $rekomendasiKacamata = ['title' => 'Single Vision / Progressive Lens', 'desc' => 'Lensa struktur khusus untuk mengoreksi titik fokus (Minus/Plus/Silinder) agar pandangan kembali tajam sempurna tanpa blur.', 'icon' => '🎯', 'color' => 'blue'];
                    } elseif (str_contains($kelasHasil, 'Normal') || str_contains($kelasHasil, 'Sehat')) {
                        $rekomendasiKacamata = ['title' => 'Anti-Blueray Lens', 'desc' => 'Mata Anda sehat! Pertahankan kondisinya dengan menangkal kelelahan mata akibat menatap layar gawai/komputer terlalu lama.', 'icon' => '💻', 'color' => 'indigo'];
                    } elseif (str_contains($kelasHasil, 'Uveitis') || str_contains($kelasHasil, 'Konjungtivitis') || str_contains($kelasHasil, 'Hordeolum') || str_contains($kelasHasil, 'Glaukoma')) {
                        $rekomendasiKacamata = ['title' => 'Photochromic Lens', 'desc' => 'Mata yang meradang sangat sensitif terhadap cahaya terang (Fotofobia). Lensa ini otomatis berubah gelap di luar ruangan untuk meredam nyeri silau.', 'icon' => '🕶️', 'color' => 'rose'];
                    }
                @endphp

                <div class="bg-gradient-to-r {{ $headerBg }} px-8 py-6 text-white flex items-center space-x-4">
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $headerIcon }}" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-white/80 uppercase">Computer Vision & Expert System</p>
                        <h2 class="text-2xl font-black tracking-tight">Lembar Hasil Screening</h2>
                    </div>
                </div>

                <div class="p-8 space-y-6">
                    
                    <div class="grid grid-cols-2 gap-4 bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Kesimpulan Akhir</span>
                            <span class="text-lg font-extrabold text-gray-900 leading-snug block mt-1">{{ $kelasHasil }}</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Tingkat Keyakinan (CF)</span>
                            <span class="text-2xl font-extrabold text-indigo-600 block mt-1">{{ $confidence ?? '0' }}%</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-5">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Interpretasi & Edukasi Medis
                        </h4>

                        @if($isGagal)
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Sistem memblokir proses analisis karena terdeteksi ketidaksesuaian klinis mutlak, atau kualitas visual gagal mengonfirmasi keberadaan komponen organ mata.</p>
                                <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl shadow-sm">
                                    <h5 class="text-sm font-bold text-amber-900 flex items-center mb-2">
                                        ⚠️ Evaluasi Input Data:
                                    </h5>
                                    <ul class="text-xs text-amber-900/90 space-y-2 list-disc pl-4">
                                        <li>Pastikan gambar yang diunggah adalah <strong>mata manusia asli</strong>, bukan objek benda mati atau gambar buram.</li>
                                        <li>Cek kembali form gejala. Gejala yang saling bertentangan (paradoks medis) akan otomatis ditolak oleh sistem pakar.</li>
                                    </ul>
                                </div>
                            </div>

                        @elseif(str_contains($kelasHasil, 'Mata Sehat') || $kelasHasil === 'Mata Normal')
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Hasil screening menunjukkan komponen optik luar mata Anda berada dalam kondisi batas fisiologis normal. Tidak terdeteksi tanda-tanda kerusakan struktural ekstrem maupun indikasi infeksi/peradangan yang signifikan.</p>
                                <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-xl shadow-sm text-emerald-900">
                                    <h5 class="text-sm font-bold mb-1">💡 Saran Perawatan Preventif:</h5>
                                    <p class="text-xs leading-relaxed">Terapkan prinsip istirahat mata 20-20-20 saat bekerja dengan komputer, pertahankan asupan nutrisi kaya antioksidan (Lutein, Vitamin A), dan cegah mata kering.</p>
                                </div>
                            </div>

                        @elseif(str_contains($kelasHasil, 'Refraksi'))
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Struktur visual luar mata Anda terdeteksi normal tanpa infeksi, namun sistem mendeteksi adanya indikasi <strong>Gangguan Refraksi</strong> (seperti Mata Minus/Miopia, Plus/Hipermetropia, atau Rabun Tua) yang ditandai dengan penurunan visus visual.</p>
                                <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl shadow-sm">
                                    <h5 class="text-sm font-bold text-blue-900 mb-1">📋 Tindakan Lanjutan:</h5>
                                    <p class="text-xs text-blue-800 leading-relaxed">Sangat disarankan untuk melakukan uji pembacaan Snellen/Jaeger secara langsung di dokter mata atau ahli optik untuk mengetahui angka dioptri lensa (ukuran kacamata) Anda secara presisi.</p>
                                </div>
                            </div>

                        @elseif($kelasHasil === 'Katarak')
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Sistem mendeteksi adanya intensitas kekeruhan lensa refraksi di dalam media mata Anda. Kondisi ini menyerupai gejala perkembangan awal penumpukan makromolekul protein lensa katarak.</p>
                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl shadow-sm space-y-2">
                                    <h5 class="text-sm font-bold text-gray-700">📋 Tindakan Kelanjutan:</h5>
                                    <p class="text-xs text-gray-600 leading-relaxed">1. Jadwalkan pemeriksaan diagnostic fisik menggunakan perangkat <strong>Slit-lamp</strong> ke Dokter Spesialis Mata (Sp.M).</p>
                                    <p class="text-xs text-gray-600 leading-relaxed">2. Lindungi kornea dari pajaran sinar UV luar ruangan menggunakan kacamata pelindung untuk memperlambat maturitas katarak.</p>
                                </div>
                            </div>

                        @elseif(str_contains($kelasHasil, 'Uveitis'))
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Terdeteksi indikasi peradangan kuat pada lapisan tengah mata (Uvea). Kondisi ini umumnya ditandai dengan mata merah pekat, nyeri berdenyut, dan sangat sensitif terhadap cahaya (Silau).</p>
                                <div class="bg-rose-50 border border-rose-200 p-4 rounded-xl shadow-sm">
                                    <h5 class="text-sm font-bold text-rose-900 mb-1">🚨 Segera Cari Penanganan Medis:</h5>
                                    <p class="text-xs text-rose-800 leading-relaxed">Uveitis bukanlah sakit mata biasa. Segera periksakan ke dokter spesialis mata karena keterlambatan penanganan dapat memicu komplikasi penglihatan permanen.</p>
                                </div>
                            </div>

                        @elseif(str_contains($kelasHasil, 'Konjungtivitis'))
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Sistem mengidentifikasi adanya kemerahan pada konjungtiva yang disertai keluhan eksudat (kotoran mata/belekan). Ini sangat identik dengan infeksi Konjungtivitis yang disebabkan oleh bakteri, virus, atau iritasi debu.</p>
                                <div class="bg-rose-50 border border-rose-200 p-4 rounded-xl shadow-sm">
                                    <h5 class="text-sm font-bold text-rose-900 mb-1">🧼 Perawatan Kebersihan:</h5>
                                    <p class="text-xs text-rose-800 leading-relaxed">Sangat menular! Jangan mengucek mata, rajin cuci tangan dengan sabun, dan bersihkan area mata menggunakan kapas bersih & air hangat. Gunakan obat tetes mata sesuai anjuran farmasi/dokter.</p>
                                </div>
                            </div>

                        @elseif(str_contains($kelasHasil, 'Hordeolum'))
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Konfirmasi manifestasi fisik menunjukkan adanya inflamasi fokal (benjolan merah) di area kelopak mata yang mengindikasikan <strong>Hordeolum (Bintitan)</strong> akibat penyumbatan dan infeksi kelenjar minyak mata.</p>
                                <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl shadow-sm">
                                    <h5 class="text-sm font-bold text-amber-900 mb-1">💡 Penanganan Awal:</h5>
                                    <p class="text-xs text-amber-800 leading-relaxed">Kompres benjolan dengan air hangat 3-4 kali sehari selama 10 menit untuk membantu meredakan bengkak. Dilarang keras memencet atau menusuk benjolan tersebut secara mandiri!</p>
                                </div>
                            </div>

                        @elseif($kelasHasil === 'Glaukoma')
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Sistem mendeteksi deviasi kelainan struktural pada dimensi *Cup-to-Disc Ratio* kepala saraf optik, yang merupakan indikasi klinis awal penyakit Glaukoma.</p>
                                <div class="bg-rose-50 border border-rose-200 p-4 rounded-xl shadow-sm space-y-2">
                                    <h5 class="text-sm font-bold text-rose-900">🚨 Peringatan Penting:</h5>
                                    <p class="text-xs text-rose-900/90 leading-relaxed font-semibold">Glaukoma sering berkembang tanpa disertai gejala rasa nyeri di fase awal. Deteksi dini sangat vital untuk mencegah penyempitan lapang pandang permanen.</p>
                                    <p class="text-xs text-rose-800 leading-relaxed">Disarankan segera melakukan tes <strong>Tonometri</strong> (pengukuran tekanan bola mata) di fasilitas kesehatan terdekat.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($rekomendasiKacamata)
                    <div class="border-t border-gray-100 pt-6">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Rekomendasi Lensa Kacamata
                        </h4>
                        
                        <div class="bg-gradient-to-br from-white to-{{ $rekomendasiKacamata['color'] }}-50 border border-{{ $rekomendasiKacamata['color'] }}-200 p-4 sm:p-5 rounded-2xl shadow-sm flex flex-col sm:flex-row items-start gap-4">
                            <div class="text-3xl bg-white p-3 rounded-xl shadow-sm border border-{{ $rekomendasiKacamata['color'] }}-100 shrink-0">
                                {{ $rekomendasiKacamata['icon'] }}
                            </div>
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">{{ $rekomendasiKacamata['title'] }}</h5>
                                <p class="text-xs text-gray-600 mt-1.5 leading-relaxed">{{ $rekomendasiKacamata['desc'] }}</p>
                                <a href="{{ url('/kacamata') }}" class="inline-flex items-center gap-1 mt-3 text-xs font-bold text-{{ $rekomendasiKacamata['color'] }}-600 hover:text-{{ $rekomendasiKacamata['color'] }}-800 bg-white border border-{{ $rekomendasiKacamata['color'] }}-200 px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition-all">
                                    Buka Katalog Lensa <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('diagnosa.index') }}" class="flex-1 bg-slate-900 text-white font-bold py-3.5 px-4 rounded-xl hover:bg-slate-800 transition-all text-sm text-center shadow-md">
                            🔄 Lakukan Diagnosa Ulang
                        </a>
                        <button onclick="window.print()" class="bg-gray-100 text-gray-700 font-bold py-3.5 px-6 rounded-xl hover:bg-gray-200 hover:shadow-sm transition-all text-sm flex items-center justify-center">
                            🖨️ Cetak Hasil
                        </button>
                    </div>

                </div>
            </div>
            
            <p class="text-[10px] text-gray-400 text-center mt-6 leading-relaxed px-4 pb-8">
                *Pemberitahuan: Sistem asistensi ini menggunakan pemrosesan kecerdasan buatan (AI) sebagai instrumen penapisan dini risiko klinis mandiri. Hasil ini bukan merupakan vonis pengganti diagnosis rekam medis dari dokter spesialis mata.
            </p>
        </div>
    </div>
</x-app-layout>