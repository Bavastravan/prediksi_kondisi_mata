<x-app-layout>
    <div class="py-8 md:py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
                
                @php
                    // 1. Normalisasi Input
                    $kelasHasil = $class ?? 'Data Inputan Gagal Terdiagnosa';
                    $tingkatKeyakinan = $confidence ?? 0;
                    
                    // 2. Tentukan Kategori Penyakit
                    $isGagal = str_contains($kelasHasil, 'Gagal') || str_contains($kelasHasil, 'Bukan Mata') || str_contains($kelasHasil, 'Berkacamata');
                    $isSehat = str_contains($kelasHasil, 'Normal') || str_contains($kelasHasil, 'Sehat');
                    $isRefraksi = str_contains($kelasHasil, 'Refraksi');
                    
                    // 3. Setup Header Warna & Ikon
                    $headerBg = 'from-slate-800 to-slate-900'; 
                    $headerIcon = 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z';

                    if ($isGagal) {
                        $headerBg = 'from-amber-500 to-amber-600'; 
                        $headerIcon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                    } elseif ($isSehat) {
                        $headerBg = 'from-emerald-500 to-emerald-600'; 
                        $headerIcon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                    } elseif ($isRefraksi) {
                        $headerBg = 'from-blue-500 to-blue-600'; 
                        $headerIcon = 'M15 12a3 3 0 11-6 0 3 3 0 016 0z';
                    } else {
                        $headerBg = 'from-rose-500 to-rose-600'; 
                        $headerIcon = 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z';
                    }

                    // 4. Kamus Penyakit
                    $infoTambahan = match (true) {
                        str_contains($kelasHasil, 'Katarak') => 'Katarak adalah kondisi di mana lensa mata menjadi keruh, biasanya akibat penuaan. Hal ini menyebabkan pandangan menjadi buram seperti melihat melalui kaca yang berembun atau berasap.',
                        str_contains($kelasHasil, 'Pterygium') => 'Pterygium adalah selaput atau jaringan yang tumbuh di bagian putih mata (sklera) dan dapat menyebar ke kornea. Sering dipicu oleh paparan sinar UV matahari, debu, dan angin secara terus-menerus.',
                        str_contains($kelasHasil, 'Hordeolum') => 'Hordeolum (bintitan) adalah benjolan merah menyakitkan di dekat tepi kelopak mata yang terlihat seperti jerawat. Umumnya disebabkan oleh infeksi bakteri pada kelenjar minyak mata.',
                        str_contains($kelasHasil, 'Iritasi') => 'Iritasi mata dapat dipicu oleh alergi, debu, asap, atau penggunaan gawai yang terlalu lama (mata lelah). Mata biasanya tampak kemerahan, berair, dan terasa perih.',
                        str_contains($kelasHasil, 'Hemorrhage') => 'Subconjunctival hemorrhage terjadi saat pembuluh darah kecil pecah tepat di bawah selaput bening mata. Terlihat menyeramkan (merah darah pekat), namun seringkali tidak berbahaya dan bisa sembuh dengan sendirinya.',
                        $isSehat => 'Mata Anda terdeteksi dalam kondisi optimal. Sistem tidak menemukan adanya kelainan visual atau peradangan yang signifikan pada citra yang Anda unggah.',
                        str_contains($kelasHasil, 'Berkacamata') => 'Sistem mendeteksi Anda menggunakan kacamata. Refleksi cahaya atau bingkai kacamata dapat menutupi area kornea sehingga menghalangi AI untuk mendeteksi penyakit dengan akurat.',
                        default => 'Pastikan gambar yang diunggah memiliki pencahayaan yang cukup terang, fokus pada bola mata, dan tidak terhalang oleh aksesoris.'
                    };

                    // 5. Tindak Lanjut & Tips Perawatan
                    $tindakLanjut = match (true) {
                        str_contains($kelasHasil, 'Katarak') => 'Segera jadwalkan konsultasi dengan dokter spesialis mata (Sp.M). Katarak yang mengganggu aktivitas dan pandangan biasanya memerlukan tindakan operasi kecil untuk mengganti lensa mata yang keruh.',
                        str_contains($kelasHasil, 'Pterygium') => 'Pantau pertumbuhan selaput secara mandiri. Jika selaput mulai mendekati bagian hitam mata (kornea) atau menyebabkan pandangan kabur dan iritasi parah yang terus-menerus, segera periksakan ke klinik mata untuk dievaluasi.',
                        str_contains($kelasHasil, 'Hordeolum') => 'Lakukan kompres air hangat pada area benjolan selama 10-15 menit, sebanyak 3-4 kali sehari. Jika benjolan tidak mengempis dalam 1 minggu atau pandangan Anda terganggu, kunjungi dokter mata terdekat.',
                        str_contains($kelasHasil, 'Iritasi') => 'Hentikan sementara aktivitas yang membuat mata lelah. Anda dapat mencoba menggunakan obat tetes air mata buatan (artificial tears) yang dijual bebas di apotek untuk meredakan kemerahan.',
                        str_contains($kelasHasil, 'Hemorrhage') => 'Jangan panik, kondisi ini umumnya akan memudar dan sembuh sendiri dalam 1-2 minggu tanpa pengobatan. JIKA nyeri berlebihan atau penglihatan buram, segera temui dokter.',
                        $isSehat => 'Pertahankan kondisi penglihatan Anda! Walaupun hasil skrining ini normal, sangat disarankan untuk tetap melakukan pemeriksaan mata menyeluruh secara rutin ke fasilitas kesehatan untuk deteksi dini.',
                        default => 'Lakukan pengambilan foto ulang. Pastikan tidak memakai kacamata, topi yang menutupi wajah, atau aksesoris lain di area mata.'
                    };

                    $tipsPerawatan = match (true) {
                        str_contains($kelasHasil, 'Katarak') => 'Perlambat penebalan katarak dengan memakai kacamata hitam anti-UV saat berada di luar ruangan. Perbanyak asupan antioksidan tinggi serta hentikan kebiasaan merokok.',
                        str_contains($kelasHasil, 'Pterygium') => 'Selalu gunakan pelindung mata seperti kacamata anti-UV atau helm bervisor saat mengendarai motor untuk menghalangi masuknya debu, angin, dan radiasi sinar matahari langsung.',
                        str_contains($kelasHasil, 'Hordeolum') => 'SANGAT DILARANG memencet atau menusuk benjolan karena dapat menyebarkan infeksi. Cuci tangan sebelum menyentuh wajah dan hentikan penggunaan kosmetik di sekitar mata.',
                        str_contains($kelasHasil, 'Iritasi') => 'Terapkan aturan 20-20-20 secara disiplin: Setiap 20 menit menatap layar, istirahatkan mata dengan melihat benda sejauh 6 meter selama 20 detik. Jangan mengucek mata.',
                        str_contains($kelasHasil, 'Hemorrhage') => 'Hindari pergerakan yang meningkatkan tekanan darah di area kepala, seperti mengucek mata dengan keras, mengangkat beban sangat berat, atau mengejan berlebihan.',
                        $isSehat => 'Cukupi kebutuhan vitamin mata harian Anda dengan mengonsumsi ikan berlemak (omega-3), telur, dan wortel. Kurangi intensitas cahaya layar gawai di malam hari.',
                        default => 'Pastikan kamera fokus langsung pada satu mata. Cahaya matahari alami atau lampu putih yang terang akan memberikan akurasi tertinggi pada kecerdasan buatan.'
                    };

                    // 6. Rekomendasi Kacamata
                    $rekomendasiKacamata = null;
                    if (!$isGagal) {
                        if (str_contains($kelasHasil, 'Katarak') || str_contains($kelasHasil, 'Pterygium')) {
                            $rekomendasiKacamata = ['title' => 'Photochromic / Bluecromic Lens', 'desc' => 'Melindungi kornea dari radiasi UV matahari yang dapat mempercepat penebalan katarak dan pertumbuhan selaput pterygium.', 'icon' => '☀️', 'color' => 'amber'];
                        } elseif ($isRefraksi) {
                            $rekomendasiKacamata = ['title' => 'Single Vision / Progressive Lens', 'desc' => 'Lensa struktur khusus untuk mengoreksi titik fokus agar pandangan kembali tajam sempurna tanpa blur.', 'icon' => '🎯', 'color' => 'blue'];
                        } elseif ($isSehat) {
                            $rekomendasiKacamata = ['title' => 'Anti-Blueray Lens', 'desc' => 'Pertahankan kesehatan mata Anda dengan perlindungan khusus untuk menangkal kelelahan mata akibat menatap layar gawai terlalu lama.', 'icon' => '💻', 'color' => 'indigo'];
                        } else {
                            $rekomendasiKacamata = ['title' => 'Photochromic Lens', 'desc' => 'Mata yang meradang sangat sensitif terhadap cahaya. Lensa ini otomatis berubah gelap di luar ruangan untuk meredam silau.', 'icon' => '🕶️', 'color' => 'rose'];
                        }
                    }
                    
                    // Colors
                    $barColor = $tingkatKeyakinan > 80 ? 'bg-emerald-500' : ($tingkatKeyakinan > 50 ? 'bg-amber-500' : 'bg-rose-500');
                    $textKeyakinan = $tingkatKeyakinan > 80 ? 'text-emerald-700' : ($tingkatKeyakinan > 50 ? 'text-amber-700' : 'text-rose-700');
                    if ($isGagal) { $barColor = 'bg-slate-300'; $textKeyakinan = 'text-slate-500'; }
                @endphp

                {{-- ================= HEADER ================= --}}
                <div class="bg-gradient-to-r {{ $headerBg }} px-6 md:px-10 py-7 text-white flex items-center gap-4">
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm shadow-sm shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $headerIcon }}" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] md:text-xs font-bold tracking-widest text-white/80 uppercase mb-0.5">Computer Vision & Expert System</p>
                        <h2 class="text-xl md:text-2xl font-black tracking-tight">Lembar Hasil Analisis</h2>
                    </div>
                </div>

                {{-- ================= HERO SECTION (FOTO & HASIL SEJAJAR) ================= --}}
                <div class="flex flex-col md:flex-row gap-6 md:gap-8 p-6 md:p-10 border-b border-slate-100 items-center md:items-start bg-white">
                    
                    {{-- Box Foto --}}
                    <div class="shrink-0 w-48 h-48 sm:w-56 sm:h-56 relative rounded-3xl overflow-hidden border-4 border-white shadow-lg bg-slate-100 flex items-center justify-center group">
                        @if(isset($image_path) && $image_path != '')
                            <img src="{{ asset('storage/' . $image_path) }}" alt="Foto Mata Pasien" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
                        @else
                            <i class="fa-solid fa-eye-slash text-5xl text-slate-300"></i>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/20"></div>
                    </div>

                    {{-- Box Kesimpulan Hasil --}}
                    <div class="flex flex-col justify-center flex-1 w-full space-y-5">
                        <div class="text-center md:text-left">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Kesimpulan Diagnosa AI</span>
                            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-3">
                                <span class="text-3xl md:text-4xl font-black text-slate-900 leading-tight">{{ $kelasHasil }}</span>
                                @if($isSehat)
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-3xl hidden md:block"></i>
                                @elseif(!$isGagal)
                                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-3xl hidden md:block"></i>
                                @endif
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 shadow-sm w-full">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Confidence Factor</span>
                                <span class="text-xl font-black {{ $textKeyakinan }}">{{ $tingkatKeyakinan }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                                <div class="{{ $barColor }} h-2.5 rounded-full transition-all duration-1000" style="width: {{ $tingkatKeyakinan }}%"></div>
                            </div>
                        </div>
                        
                        {{-- Status Badge --}}
                        <div class="inline-flex items-center justify-center md:justify-start gap-2 text-xs font-bold text-slate-500 bg-white border border-slate-200 px-4 py-2.5 rounded-xl shadow-sm w-fit mx-auto md:mx-0">
                            <i class="fa-solid fa-microchip text-blue-500"></i> {{ $message ?? 'Proses klasifikasi selesai.' }}
                        </div>
                    </div>
                </div>

                {{-- ================= DETAILS SECTION (GRID KARTU) ================= --}}
                <div class="p-6 md:p-10 bg-slate-50/50 space-y-6">
                    
                    <h4 class="text-sm font-bold uppercase tracking-widest text-slate-600 mb-2 flex items-center">
                        <i class="fa-solid fa-notes-medical mr-2 text-blue-500"></i> Rincian & Edukasi Medis
                    </h4>

                    @php
                        $boxColor = $isGagal ? 'amber' : ($isSehat ? 'emerald' : 'rose');
                    @endphp

                    {{-- Grid 2 Kolom untuk Interpretasi & Definisi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-{{ $boxColor }}-50 border border-{{ $boxColor }}-200 p-5 rounded-2xl shadow-sm">
                            <h5 class="text-xs font-bold mb-2 text-{{ $boxColor }}-900 uppercase tracking-wider flex items-center gap-2">
                                @if($isGagal) ⚠️ Evaluasi Sistem
                                @elseif($isSehat) 💡 Hasil Evaluasi
                                @else 🚨 Indikasi Ditemukan
                                @endif
                            </h5>
                            <p class="text-[13px] leading-relaxed font-medium text-{{ $boxColor }}-800">
                                {!! $kesimpulan ?? '-' !!}
                            </p>
                        </div>

                        <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm">
                            <h5 class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-2 flex items-center"><i class="fa-solid fa-book-medical mr-2 text-blue-500"></i> Definisi Medis</h5>
                            <p class="text-[13px] leading-relaxed text-slate-600">
                                {{ $infoTambahan }}
                            </p>
                        </div>
                    </div>

                    {{-- Grid 2 Kolom untuk Tindak Lanjut & Tips --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-indigo-50/50 border border-indigo-100 p-5 rounded-2xl shadow-sm hover:border-indigo-300 transition-colors">
                            <h5 class="text-xs font-bold text-indigo-700 uppercase tracking-wider mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-user-doctor text-indigo-500"></i> Tindak Lanjut Mandiri
                            </h5>
                            <p class="text-[13px] leading-relaxed text-slate-700 font-medium">{{ $tindakLanjut }}</p>
                        </div>
                        
                        <div class="bg-emerald-50/50 border border-emerald-100 p-5 rounded-2xl shadow-sm hover:border-emerald-300 transition-colors">
                            <h5 class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-shield-heart text-emerald-500"></i> Tips Perawatan
                            </h5>
                            <p class="text-[13px] leading-relaxed text-slate-700 font-medium">{{ $tipsPerawatan }}</p>
                        </div>
                    </div>

                    {{-- Rekomendasi Kacamata Full Width --}}
                    @if($rekomendasiKacamata)
                    <div class="mt-4">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-slate-600 mb-4 mt-8 flex items-center">
                            <i class="fa-solid fa-glasses mr-2 text-blue-500"></i> Rekomendasi Lensa Proteksi
                        </h4>
                        <div class="bg-gradient-to-r from-white to-{{ $rekomendasiKacamata['color'] }}-50 border border-{{ $rekomendasiKacamata['color'] }}-200 p-6 rounded-2xl shadow-sm flex flex-col sm:flex-row items-center sm:items-start gap-5">
                            <div class="text-4xl bg-white p-4 rounded-2xl shadow-sm border border-{{ $rekomendasiKacamata['color'] }}-100 shrink-0">
                                {{ $rekomendasiKacamata['icon'] }}
                            </div>
                            <div class="text-center sm:text-left">
                                <h5 class="text-base font-black text-slate-900">{{ $rekomendasiKacamata['title'] }}</h5>
                                <p class="text-[13px] text-slate-600 mt-1.5 leading-relaxed font-medium">{{ $rekomendasiKacamata['desc'] }}</p>
                                
                                <a href="{{ route('kacamata.index') }}" class="inline-flex items-center gap-2 mt-4 text-xs font-bold text-{{ $rekomendasiKacamata['color'] }}-700 hover:text-white bg-white hover:bg-{{ $rekomendasiKacamata['color'] }}-600 border border-{{ $rekomendasiKacamata['color'] }}-200 hover:border-transparent px-5 py-2.5 rounded-xl shadow-sm transition-all duration-200">
                                    Buka Katalog Lensa <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>

                {{-- ================= TOMBOL AKSI ================= --}}
                <div class="p-6 md:p-8 bg-white border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3">
                   
                    
                    <a href="{{ route('diagnosa.index') }}" class="bg-slate-900 text-white font-bold py-3.5 px-8 rounded-xl hover:bg-indigo-600 transition-colors text-sm text-center shadow-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-rotate-right"></i> Lakukan Diagnosa Ulang
                    </a>

                     <a href="{{ route('riwayat.index') }}" class="bg-white text-slate-700 font-bold py-3.5 px-6 rounded-xl hover:bg-slate-50 transition-colors text-sm flex items-center justify-center gap-2 border border-slate-300 shadow-sm text-center">
                        <i class="fa-solid fa-folder-open"></i>Selesai
                    </a>
                </div>

            </div>
            
            <p class="text-[10px] font-medium text-slate-400 text-center mt-6 leading-relaxed px-4 pb-8">
                *Pemberitahuan: Sistem asistensi ini menggunakan pemrosesan kecerdasan buatan (AI) berbasis Computer Vision sebagai instrumen penapisan dini risiko klinis mandiri. Hasil ini bukan merupakan vonis pengganti diagnosis rekam medis dari dokter spesialis mata (Sp.M).
            </p>
        </div>
    </div>

     <footer class="bg-white border-t border-slate-200 pt-6 pb-12 text-center relative">
        <div class="container mx-auto px-6 text-center">
            <p class="text-slate-500 text-[10px] sm:text-xs">© 2026 <strong>Sistem Pakar Pendeteksi Gangguan Mata</strong>. Dirancang untuk edukasi dan bantuan medis berbasis komputasi.</p>
        </div>
    </footer>
</x-app-layout>