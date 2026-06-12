<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
                
                @php
                    // 1. Normalisasi Input
                    $kelasHasil = $class ?? 'Data Inputan Gagal Terdiagnosa';
                    
                    // 2. Tentukan Kategori Penyakit (Untuk styling & header)
                    $isGagal = str_contains($kelasHasil, 'Gagal') || str_contains($kelasHasil, 'Bukan Mata') || str_contains($kelasHasil, 'Berkacamata');
                    $isSehat = str_contains($kelasHasil, 'Normal') || str_contains($kelasHasil, 'Sehat');
                    $isRefraksi = str_contains($kelasHasil, 'Refraksi');
                    
                    // 3. Setup Header Warna & Ikon berdasarkan Kategori
                    $headerBg = 'from-slate-800 to-slate-900'; 
                    $headerIcon = 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z';

                    if ($isGagal) {
                        $headerBg = 'from-amber-500 to-amber-600'; // Warna Peringatan
                        $headerIcon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                    } elseif ($isSehat) {
                        $headerBg = 'from-emerald-500 to-emerald-600'; // Warna Aman
                        $headerIcon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                    } elseif ($isRefraksi) {
                        $headerBg = 'from-blue-500 to-blue-600'; // Warna Info
                        $headerIcon = 'M15 12a3 3 0 11-6 0 3 3 0 016 0z';
                    } else {
                        // Penyakit (Katarak, Uveitis, Belekan, Bintitan, Pterygium, Hemorrhage)
                        $headerBg = 'from-rose-500 to-rose-600'; // Warna Bahaya
                        $headerIcon = 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z';
                    }

                    // 4. Setup Rekomendasi Kacamata Terintegrasi (Dihilangkan jika input Gagal)
                    $rekomendasiKacamata = null;
                    if (!$isGagal) {
                        if (str_contains($kelasHasil, 'Katarak') || str_contains($kelasHasil, 'Pterygium')) {
                            $rekomendasiKacamata = ['title' => 'Photochromic / Bluecromic Lens', 'desc' => 'Melindungi kornea dari radiasi UV matahari yang dapat mempercepat penebalan katarak dan pertumbuhan selaput pterygium.', 'icon' => '☀️', 'color' => 'amber'];
                        } elseif ($isRefraksi) {
                            $rekomendasiKacamata = ['title' => 'Single Vision / Progressive Lens', 'desc' => 'Lensa struktur khusus untuk mengoreksi titik fokus (Minus/Plus/Silinder) agar pandangan kembali tajam sempurna tanpa blur.', 'icon' => '🎯', 'color' => 'blue'];
                        } elseif ($isSehat) {
                            $rekomendasiKacamata = ['title' => 'Anti-Blueray Lens', 'desc' => 'Pertahankan kesehatan mata Anda dengan perlindungan khusus untuk menangkal kelelahan mata akibat menatap layar gawai terlalu lama.', 'icon' => '💻', 'color' => 'indigo'];
                        } else {
                            // Untuk kondisi meradang (Uveitis, Iritasi, Hordeolum, Hemorrhage)
                            $rekomendasiKacamata = ['title' => 'Photochromic Lens', 'desc' => 'Mata yang sedang meradang atau luka sangat sensitif terhadap cahaya. Lensa ini otomatis berubah gelap di luar ruangan untuk meredam nyeri silau.', 'icon' => '🕶️', 'color' => 'rose'];
                        }
                    }
                @endphp

                {{-- ================= HEADER ================= --}}
                <div class="bg-gradient-to-r {{ $headerBg }} px-8 py-6 text-white flex items-center gap-4">
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm shadow-sm shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $headerIcon }}" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold tracking-widest text-white/80 uppercase">Computer Vision & Expert System</p>
                        <h2 class="text-2xl font-black tracking-tight">Lembar Hasil Screening</h2>
                    </div>
                </div>

                <div class="p-8 space-y-6">
                    
                    {{-- ================= RINGKASAN HASIL ================= --}}
                    <div class="grid grid-cols-2 gap-4 bg-slate-50 p-5 rounded-2xl border border-slate-200 shadow-sm">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Kesimpulan Akhir</span>
                            <span class="text-lg font-extrabold text-slate-900 leading-snug block mt-1">{{ $kelasHasil }}</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Tingkat Keyakinan (CF)</span>
                            <span class="text-2xl font-extrabold {{ $isGagal ? 'text-amber-600' : 'text-blue-600' }} block mt-1">
                                {{ $confidence ?? '0' }}%
                            </span>
                        </div>
                    </div>

                    {{-- ================= EDUKASI MEDIS ================= --}}
                    <div class="border-t border-slate-100 pt-5">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4 flex items-center">
                            <i class="fa-solid fa-notes-medical mr-2 text-slate-400"></i>
                            Interpretasi & Edukasi Medis
                        </h4>

                        @php
                            // Tentukan warna box edukasi berdasarkan status
                            $boxColor = $isGagal ? 'amber' : ($isSehat ? 'emerald' : 'rose');
                        @endphp
                        
                        <div class="bg-{{ $boxColor }}-50 border border-{{ $boxColor }}-200 p-5 rounded-2xl shadow-sm text-{{ $boxColor }}-900">
                            <h5 class="text-sm font-bold mb-2 flex items-center gap-2">
                                @if($isGagal) ⚠️ Evaluasi Tindakan:
                                @elseif($isSehat) 💡 Saran Perawatan Preventif:
                                @else 🚨 Indikasi & Tindakan Lanjutan:
                                @endif
                            </h5>
                            
                            {{-- 💡 PERBAIKAN UTAMA: Render text HTML langsung dari Controller --}}
                            <p class="text-[13px] leading-relaxed font-medium text-{{ $boxColor }}-800">
                                {!! $kesimpulan !!}
                            </p>
                        </div>
                    </div>

                    {{-- ================= REKOMENDASI KACAMATA ================= --}}
                    @if($rekomendasiKacamata)
                    <div class="border-t border-slate-100 pt-6">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4 flex items-center">
                            <i class="fa-solid fa-glasses mr-2 text-slate-400"></i>
                            Rekomendasi Lensa Proteksi
                        </h4>
                        
                        <div class="bg-gradient-to-br from-white to-{{ $rekomendasiKacamata['color'] }}-50 border border-{{ $rekomendasiKacamata['color'] }}-200 p-5 rounded-2xl shadow-sm flex flex-col sm:flex-row items-start gap-4">
                            <div class="text-3xl bg-white p-3.5 rounded-xl shadow-sm border border-{{ $rekomendasiKacamata['color'] }}-100 shrink-0 flex items-center justify-center">
                                {{ $rekomendasiKacamata['icon'] }}
                            </div>
                            <div>
                                <h5 class="text-sm font-extrabold text-slate-900">{{ $rekomendasiKacamata['title'] }}</h5>
                                <p class="text-xs text-slate-600 mt-1.5 leading-relaxed font-medium">{{ $rekomendasiKacamata['desc'] }}</p>
                                
                                {{-- Tombol ke Halaman Kacamata --}}
                                <a href="{{ route('kacamata.index') }}" class="inline-flex items-center gap-2 mt-4 text-xs font-bold text-{{ $rekomendasiKacamata['color'] }}-700 hover:text-white bg-white hover:bg-{{ $rekomendasiKacamata['color'] }}-600 border border-{{ $rekomendasiKacamata['color'] }}-200 hover:border-transparent px-4 py-2 rounded-xl shadow-sm transition-all duration-200">
                                    Buka Katalog Lensa <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- ================= TOMBOL AKSI ================= --}}
<div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
    <a href="{{ route('diagnosa.index') }}" class="flex-1 bg-slate-900 text-white font-bold py-3.5 px-4 rounded-xl hover:bg-blue-600 transition-colors text-sm text-center shadow-md flex items-center justify-center gap-2">
        <i class="fa-solid fa-rotate-right"></i> Lakukan Diagnosa Ulang
    </a>
    
    <a href="{{ route('riwayat.index') }}" class="bg-slate-100 text-slate-700 font-bold py-3.5 px-6 rounded-xl hover:bg-slate-200 transition-colors text-sm flex items-center justify-center gap-2 border border-slate-200 text-center">
        <i class="fa-solid fa-circle-check"></i> Selesai
    </a>
</div>

                </div>
            </div>
            
            <p class="text-[10px] font-medium text-slate-400 text-center mt-6 leading-relaxed px-4 pb-8">
                *Pemberitahuan: Sistem asistensi ini menggunakan pemrosesan kecerdasan buatan (AI) sebagai instrumen penapisan dini risiko klinis mandiri. Hasil ini bukan merupakan vonis pengganti diagnosis rekam medis dari dokter spesialis mata (Sp.M).
            </p>
        </div>
    </div>
</x-app-layout>