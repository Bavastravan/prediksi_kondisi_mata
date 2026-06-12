<x-app-layout>
    <div class="py-6 md:py-12 bg-slate-900 min-h-screen text-slate-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6 md:mb-8 text-center">
                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">Pemeriksaan Ketajaman Mata Refraksi</h1>
                <p class="text-slate-400 text-xs md:text-sm mt-2">Uji batas kemampuan visual mandiri untuk deteksi dini indikasi mata Minus atau Plus.</p>
            </div>

            <div class="flex justify-center mb-6">
                <div class="bg-slate-950 p-1.5 rounded-2xl inline-flex border border-slate-700 shadow-inner overflow-x-auto w-full md:w-auto">
                    <button id="tab-minus" onclick="switchMode('minus')" class="flex-1 md:flex-none px-4 md:px-8 py-2.5 rounded-xl text-xs md:text-sm font-bold bg-blue-600 text-white shadow-lg transition-all whitespace-nowrap">
                        <i class="fa-solid fa-expand mr-2"></i> Uji Jarak Jauh (Minus dan Plus)
                    </button>
                    <button id="tab-plus" onclick="switchMode('plus')" class="flex-1 md:flex-none px-4 md:px-8 py-2.5 rounded-xl text-xs md:text-sm font-bold text-slate-400 hover:text-white hover:bg-slate-800 transition-all whitespace-nowrap">
                        <i class="fa-solid fa-book-open mr-2"></i> Uji Baca Dekat (Plus)
                    </button>
                </div>
            </div>

            <div class="bg-slate-800 rounded-3xl p-4 md:p-8 border border-slate-700 shadow-2xl relative">
                
                <div id="panel-minus" class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 transition-all duration-300">
                    <div class="space-y-4 md:col-span-1 bg-slate-800/50 p-4 md:p-5 rounded-2xl border border-slate-700/60 flex flex-col justify-between shadow-inner">
                        <div>
                            <div class="inline-flex bg-blue-500/10 text-blue-400 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 border border-blue-500/20">Protokol Snellen</div>
                            <h2 class="text-base font-bold text-white">Panduan Pengujian:</h2>
                            <ol class="text-[11px] md:text-xs text-slate-400 list-decimal list-inside space-y-2.5 mt-3 leading-relaxed">
                                <li>Posisikan mata Anda tegak lurus sejajar monitor.</li>
                                <li>Mundurlah tepat sejauh <strong class="text-blue-400">2 Meter</strong> dari layar.</li>
                                <li>Tutup satu mata menggunakan telapak tangan.</li>
                                <li>Fokus pada huruf/angka di dalam kotak putih. Tekan <strong class="text-emerald-400">Jelas</strong> atau <strong class="text-rose-400">Buram</strong>.</li>
                            </ol>
                        </div>
                        <div class="pt-4 border-t border-slate-700 mt-4">
                            <div class="text-[10px] md:text-xs font-bold text-slate-300 uppercase mb-2 flex justify-between">
                                <span>Baris Ketajaman:</span>
                                <span id="step-text-minus">Baris 1/6 (20/200)</span>
                            </div>
                            <div class="w-full bg-slate-700 h-2 rounded-full overflow-hidden">
                                <div id="progress-bar-minus" class="bg-blue-500 h-full transition-all duration-300" style="width: 16.6%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 flex flex-col items-center justify-center bg-slate-950 rounded-2xl border-2 border-slate-700 p-4 md:p-6 min-h-[350px]">
                        <div class="flex-1 flex flex-col items-center justify-center bg-white rounded-xl w-full p-4 md:p-8 min-h-[180px] shadow-inner relative overflow-hidden">
                            <div id="snellen-score-live" class="absolute top-2 right-3 text-[10px] font-mono font-bold text-slate-400">VA Target: 20/200</div>
                            <div id="snellen-char" class="text-black font-black select-none tracking-widest font-mono uppercase transition-all duration-150" style="line-height: 1;">E</div>
                        </div>

                        <div class="w-full mt-6 flex flex-col items-center">
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-3 text-center">Apakah Karakter Di Atas Terbaca Jelas?</p>
                            <div class="flex space-x-3 w-full max-w-xs justify-center">
                                <button onclick="prosesJawabanMinus(false)" class="flex-1 bg-rose-600 hover:bg-rose-500 text-white font-black py-3 px-4 rounded-xl shadow-lg active:scale-95 transition-all text-center flex items-center justify-center gap-2 border border-rose-400/30">
                                    <i class="fa-solid fa-xmark"></i> <span class="text-xs">Buram</span>
                                </button>
                                <button onclick="prosesJawabanMinus(true)" class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-white font-black py-3 px-4 rounded-xl shadow-lg active:scale-95 transition-all text-center flex items-center justify-center gap-2 border border-emerald-400/30">
                                    <i class="fa-solid fa-check"></i> <span class="text-xs">Jelas</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="panel-plus" class="hidden grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 transition-all duration-300">
                    <div class="space-y-4 md:col-span-1 bg-slate-800/50 p-4 md:p-5 rounded-2xl border border-slate-700/60 flex flex-col justify-between shadow-inner">
                        <div>
                            <div class="inline-flex bg-amber-500/10 text-amber-400 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 border border-amber-500/20">Protokol Klinis Jaeger</div>
                            <h2 class="text-base font-bold text-white">Panduan Pengujian:</h2>
                            <ol class="text-[11px] md:text-xs text-slate-400 list-decimal list-inside space-y-2.5 mt-3 leading-relaxed">
                                <li>Pegang layar HP atau duduk dari layar monitor pada jarak baca normal buku (<strong class="text-amber-400">30 cm - 40 cm</strong>).</li>
                                <li>Pastikan pencahayaan ruangan cukup terang.</li>
                                <li>Baca teks paragraf di samping. Tekan tombol sesuai dengan kenyamanan mata Anda.</li>
                            </ol>
                        </div>
                        <div class="pt-4 border-t border-slate-700 mt-4">
                            <div class="text-[10px] md:text-xs font-bold text-slate-300 uppercase mb-2 flex justify-between">
                                <span>Level Paragraf:</span>
                                <span id="step-text-plus">Level 1/6 (J10)</span>
                            </div>
                            <div class="w-full bg-slate-700 h-2 rounded-full overflow-hidden">
                                <div id="progress-bar-plus" class="bg-amber-500 h-full transition-all duration-300" style="width: 16.6%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 flex flex-col items-center justify-center bg-slate-950 rounded-2xl border-2 border-slate-700 p-4 md:p-6 min-h-[350px]">
                        <div class="flex-1 flex flex-col items-center justify-center bg-white rounded-xl w-full p-6 md:p-8 min-h-[180px] shadow-inner relative overflow-hidden">
                            <div id="jaeger-score-live" class="absolute top-2 right-3 text-[10px] font-mono font-bold text-slate-400">Standar: Jaeger 10</div>
                            <p id="jaeger-text" class="text-slate-900 font-serif text-center transition-all duration-300 leading-relaxed tracking-wide font-medium">
                                Memuat teks...
                            </p>
                        </div>

                        <div class="w-full mt-6 flex flex-col items-center">
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-3 text-center">Apakah Teks Di Atas Bisa Dibaca Tanpa Berbayang?</p>
                            <div class="flex space-x-3 w-full max-w-xs justify-center">
                                <button onclick="prosesJawabanPlus(false)" class="flex-1 bg-rose-600 hover:bg-rose-500 text-white font-black py-3 px-4 rounded-xl shadow-lg active:scale-95 transition-all text-center flex items-center justify-center gap-2 border border-rose-400/30">
                                    <i class="fa-solid fa-eye-low-vision"></i> <span class="text-xs">Berbayang</span>
                                </button>
                                <button onclick="prosesJawabanPlus(true)" class="flex-1 bg-amber-600 hover:bg-amber-500 text-white font-black py-3 px-4 rounded-xl shadow-lg active:scale-95 transition-all text-center flex items-center justify-center gap-2 border border-amber-400/30">
                                    <i class="fa-solid fa-book-open-reader"></i> <span class="text-xs">Terbaca Jelas</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-6 p-5 bg-amber-950/40 border border-amber-900/60 rounded-2xl text-xs text-slate-300 leading-relaxed flex gap-3.5 items-start shadow-lg">
                <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-1 text-lg"></i>
                <div>
                    <strong class="text-amber-400 uppercase tracking-widest text-[10px] block mb-1">Peringatan Medis:</strong> 
                    <p class="opacity-90">Hasil skrining refraksi ini bersifat sementara dan mandiri. Bila ingin mengetahui hasil yang mutlak dan dilakukan oleh ahlinya, silakan datang ke Optik Kacamata atau Dokter Spesialis Mata terdekat.</p>
                </div>
            </div>

        </div>
    </div>

    <div id="modal-hasil" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center hidden p-4 transition-all duration-300">
        <div class="bg-slate-800 border-2 border-slate-700 rounded-3xl p-6 md:p-8 max-w-sm w-full shadow-2xl text-center">
            
            <div id="modal-icon-container" class="w-16 h-16 bg-blue-500/10 text-blue-400 rounded-full flex items-center justify-center mx-auto mb-4 border border-blue-500/30 shadow-inner">
                <i id="modal-icon" class="fa-solid fa-glasses text-2xl"></i>
            </div>
            
            <h3 class="text-xl font-black text-white uppercase tracking-wider">Kartu Hasil Evaluasi</h3>
            <p id="modal-subtitle" class="text-slate-400 text-[11px] mt-1">Skrining Refraksi Digital</p>
            
            <div class="my-5 p-5 bg-slate-950 rounded-2xl border border-slate-700 text-left space-y-3 shadow-inner">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-400">Modul Pengujian:</span>
                    <span id="res-tipe-tes" class="font-bold text-slate-200 bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700/60 text-xs">Tes Jauh (Minus)</span>
                </div>
                
                <div class="flex justify-between items-center text-sm pt-1">
                    <span class="text-slate-400">Nilai Skala Ketajaman:</span>
                    <span id="res-score-value" class="font-black text-blue-400 text-base font-mono">20/20</span>
                </div>
                
                <div class="mt-3 pt-3 border-t border-slate-800 flex flex-col gap-1.5">
                    <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Indikasi Klinis Refraksi:</span>
                    <div id="res-box-kesimpulan" class="bg-blue-950/40 border border-blue-500/40 rounded-xl p-3 shadow-inner">
                        <span id="res-kesimpulan" class="font-extrabold text-sm text-blue-300 leading-relaxed block text-center">
                            Mata Normal Sempurna / Bebas Minus
                        </span>
                    </div>
                </div>
            </div>

            <div class="mb-5 px-2 text-xs text-slate-400 leading-relaxed">
                Ketahui keperluan kacamata sesuai kebutuhan Anda 
                <a href="{{ url('/kacamata') }}" class="text-blue-400 hover:text-blue-300 font-bold underline underline-offset-4 transition-all hover:scale-105 inline-block">
                    Disini
                </a>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-2">
                <button onclick="ujiUlang()" class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-slate-200 font-bold py-3 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 border border-slate-600 shadow-md">
    <i class="fa-solid fa-rotate-right text-slate-400"></i> Uji Ulang
</button>
                <button onclick="selesaiTes()" class="bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white font-bold py-3 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 shadow-lg shadow-emerald-950/30">
    <i class="fa-solid fa-circle-check"></i> Selesai
</button>
            </div>
            
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 pt-6 pb-12 text-center relative">
        <div class="container mx-auto px-6 text-center">
                       <p class="text-slate-500 text-xs">© 2026 <strong>Sistem Pakar Pendeteksi Gangguan Mata</strong>. Dirancang untuk edukasi dan bantuan medis berbasis komputasi.</p>
        </div>
    </footer>
    
    <script>
        // ==========================================
        // 🎛️ CONTROLLER TAB NAVIGASI
        // ==========================================
        function konversiKeConfidence(finalIdx) {
    return Math.round(((finalIdx + 1) / 6) * 100);
}
        let currentMode = 'minus';
        function switchMode(mode) {
    currentMode = mode; // 👈 simpan mode yang dipilih user

    const btnMinus = document.getElementById('tab-minus');
    const btnPlus = document.getElementById('tab-plus');
    const panelMinus = document.getElementById('panel-minus');
    const panelPlus = document.getElementById('panel-plus');

    if (mode === 'minus') {
        btnMinus.className = "flex-1 md:flex-none px-4 md:px-8 py-2.5 rounded-xl text-xs md:text-sm font-bold bg-blue-600 text-white shadow-lg transition-all whitespace-nowrap";
        btnPlus.className  = "flex-1 md:flex-none px-4 md:px-8 py-2.5 rounded-xl text-xs md:text-sm font-bold text-slate-400 hover:text-white hover:bg-slate-800 transition-all whitespace-nowrap";
        panelPlus.classList.add('hidden');
        panelPlus.classList.remove('grid');
        panelMinus.classList.remove('hidden');
        panelMinus.classList.add('grid');
    } else {
        btnPlus.className  = "flex-1 md:flex-none px-4 md:px-8 py-2.5 rounded-xl text-xs md:text-sm font-bold bg-amber-600 text-white shadow-lg transition-all whitespace-nowrap";
        btnMinus.className = "flex-1 md:flex-none px-4 md:px-8 py-2.5 rounded-xl text-xs md:text-sm font-bold text-slate-400 hover:text-white hover:bg-slate-800 transition-all whitespace-nowrap";
        panelMinus.classList.add('hidden');
        panelMinus.classList.remove('grid');
        panelPlus.classList.remove('hidden');
        panelPlus.classList.add('grid');
    }
}

function ujiUlang() {
    // Reset state tes Minus
    stepMinus = 0;
    scoreMinus = 0;
    document.getElementById('step-text-minus').innerText = `Baris 1/6 (${vaMinus[0]})`;
    document.getElementById('progress-bar-minus').style.width = "16.6%";
    loadCharMinus();

    // Reset state tes Plus
    stepPlus = 0;
    scorePlus = 0;
    document.getElementById('step-text-plus').innerText = `Level 1/6 (${vaPlus[0]})`;
    document.getElementById('progress-bar-plus').style.width = "16.6%";
    loadTextPlus();

    // Tutup modal
    document.getElementById('modal-hasil').classList.add('hidden');

    // Kembali ke tab yang sedang aktif sebelumnya
    switchMode(currentMode);
}

        // ==========================================
        // 👁️ ENGINE 1: TES RABUN JAUH (MINUS)
        // ==========================================
        let stepMinus = 0;
        let scoreMinus = 0;
        const charsMinus = ['E', '7', 'P', '4', 'O', '9', 'L', '3', 'D', '5', 'C', '8', 'V'];
        const sizesMinus = [240, 170, 125, 90, 60, 38];
        const vaMinus    = ["20/200", "20/100", "20/70", "20/50", "20/30", "20/20"];
        const conclusMinus = [
            "Penurunan Visus Jarak Jauh Berat (Indikasi Miopia/Minus Tinggi, Astigmatisme, atau Plus Ekstrem). Butuh koreksi optik segera.",
            "Penurunan Visus Jarak Jauh Sedang (Suspek Mata Minus -2.50 s/d -3.50 Dioptri atau Silinder).",
            "Penurunan Visus Jarak Jauh Ringan (Suspek Mata Minus -1.25 s/d -2.00 Dioptri).",
            "Gangguan Refraksi Jauh Sangat Ringan (Suspek Mata Minus -0.50 s/d -1.00 Dioptri).",
            "Mata Normal Batas Ambang Rendah (Ketajaman visual jarak jauh cukup baik).",
            "Mata Normal Sempurna (Emmetropia Visual Ideal). Tidak terindikasi Rabun Jauh."
        ];

        function loadCharMinus() {
            let rc = charsMinus[Math.floor(Math.random() * charsMinus.length)];
            let el = document.getElementById('snellen-char');
            el.style.fontSize = sizesMinus[stepMinus] + "px";
            el.innerHTML = rc;
            document.getElementById('snellen-score-live').innerText = `VA Target: ${vaMinus[stepMinus]}`;
        }

        function prosesJawabanMinus(isJelas) {
            if (isJelas) scoreMinus++;
            stepMinus++;
            if (stepMinus < sizesMinus.length) {
                document.getElementById('step-text-minus').innerText = `Baris ${stepMinus + 1}/6 (${vaMinus[stepMinus]})`;
                document.getElementById('progress-bar-minus').style.width = ((stepMinus + 1) / 6 * 100) + "%";
                loadCharMinus();
            } else {
                tampilkanHasil('minus', scoreMinus);
            }
        }

        // ==========================================
        // 📖 ENGINE 2: TES RABUN DEKAT (PLUS/TUA)
        // ==========================================
        let stepPlus = 0;
        let scorePlus = 0;
        
        // Teks paragraf edukasi yang terstruktur
        const textsPlus = [
            "Kemajuan teknologi telah mengubah cara kita bekerja dan berkomunikasi setiap harinya.",
            "Membaca buku di tempat terang sangat disarankan untuk menjaga kesehatan retina mata.",
            "Sayuran hijau dan wortel mengandung vitamin yang baik untuk mencegah penuaan sel optik.",
            "Pemeriksaan refraksi mata secara rutin dianjurkan bagi individu berusia di atas empat puluh tahun.",
            "Ketajaman penglihatan jarak dekat dapat menurun secara alami seiring bertambahnya usia kronologis seseorang.",
            "Gunakan lensa baca kacamata plus yang sesuai standar medis agar otot mata tidak cepat merasa kelelahan saat fokus."
        ];
        
        // Skala Jaeger (J10 = Sangat Besar, J1 = Super Kecil seukuran koran asli)
        const sizesPlus = [32, 24, 18, 14, 11, 9]; 
        const vaPlus    = ["Jaeger 10", "Jaeger 7", "Jaeger 5", "Jaeger 3", "Jaeger 2", "Jaeger 1"];
        const conclusPlus = [
            "Rabun Dekat Berat (Presbiopia Lanjut). Sangat kesulitan membaca. Butuh lensa Kacamata Plus tinggi.",
            "Rabun Dekat Sedang (Butuh Kacamata Plus sekitar +2.00 Dioptri).",
            "Rabun Dekat Ringan (Butuh Kacamata Plus sekitar +1.25 Dioptri).",
            "Gejala Awal Mata Plus (Presbiopia Ringan). Terasa lelah saat membaca lama.",
            "Penglihatan Dekat Baik (Normal).",
            "Mata Normal Sempurna (Ketajaman Jarak Dekat Sangat Presisi)."
        ];

        function loadTextPlus() {
            let el = document.getElementById('jaeger-text');
            el.style.fontSize = sizesPlus[stepPlus] + "px";
            el.innerHTML = textsPlus[stepPlus];
            document.getElementById('jaeger-score-live').innerText = `Standar: ${vaPlus[stepPlus]}`;
        }

        function prosesJawabanPlus(isJelas) {
            if (isJelas) scorePlus++;
            stepPlus++;
            if (stepPlus < sizesPlus.length) {
                document.getElementById('step-text-plus').innerText = `Level ${stepPlus + 1}/6 (${vaPlus[stepPlus]})`;
                document.getElementById('progress-bar-plus').style.width = ((stepPlus + 1) / 6 * 100) + "%";
                loadTextPlus();
            } else {
                tampilkanHasil('plus', scorePlus);
            }
        }

        // ==========================================
        // 📊 FUNGSI RENDER MODAL HASIL UNIVERSAL
        // ==========================================
        let dataHasilTerakhir = null; // 👈 simpan hasil tes terakhir

function tampilkanHasil(mode, totalBenar) {
    let finalIdx = totalBenar - 1;
    if (finalIdx < 0) finalIdx = 0;

    const modal = document.getElementById('modal-hasil');
    const iconBox = document.getElementById('modal-icon-container');
    const valScore = document.getElementById('res-score-value');
    const valKesimpulan = document.getElementById('res-kesimpulan');
    const boxKesimpulan = document.getElementById('res-box-kesimpulan');

    const confidence = konversiKeConfidence(finalIdx); // 👈 hitung confidence

    if (mode === 'minus') {
        document.getElementById('res-tipe-tes').innerText = "Tes Refraksi Jarak Jauh";
        document.getElementById('res-tipe-tes').className = "font-bold text-slate-200 bg-blue-900/50 px-2.5 py-1 rounded-md border border-blue-700/60 text-xs";
        
        iconBox.className = "w-16 h-16 bg-blue-500/10 text-blue-400 rounded-full flex items-center justify-center mx-auto mb-4 border border-blue-500/30 shadow-inner";
        valScore.className = "font-black text-blue-400 text-base font-mono";
        valScore.innerText = vaMinus[finalIdx];
        
        boxKesimpulan.className = "bg-blue-950/40 border border-blue-500/40 rounded-xl p-3 shadow-inner";
        valKesimpulan.className = "font-extrabold text-sm text-blue-300 leading-relaxed block text-center";
        valKesimpulan.innerText = conclusMinus[finalIdx];

        // 👈 simpan data hasil
        dataHasilTerakhir = {
            type: 'minus',
            va_score: vaMinus[finalIdx],
            conclusion: conclusMinus[finalIdx],
            confidence: confidence
        };
    } else {
        document.getElementById('res-tipe-tes').innerText = "Tes Baca (Presbiopia/Plus)";
        document.getElementById('res-tipe-tes').className = "font-bold text-slate-200 bg-amber-900/50 px-2.5 py-1 rounded-md border border-amber-700/60 text-xs";
        
        iconBox.className = "w-16 h-16 bg-amber-500/10 text-amber-400 rounded-full flex items-center justify-center mx-auto mb-4 border border-amber-500/30 shadow-inner";
        valScore.className = "font-black text-amber-400 text-base font-mono";
        valScore.innerText = vaPlus[finalIdx];
        
        boxKesimpulan.className = "bg-amber-950/40 border border-amber-500/40 rounded-xl p-3 shadow-inner";
        valKesimpulan.className = "font-extrabold text-sm text-amber-300 leading-relaxed block text-center";
        valKesimpulan.innerText = conclusPlus[finalIdx];

        // 👈 simpan data hasil
        dataHasilTerakhir = {
            type: 'plus',
            va_score: vaPlus[finalIdx],
            conclusion: conclusPlus[finalIdx],
            confidence: confidence
        };
    }

    modal.classList.remove('hidden');
} 

function selesaiTes() {
    if (!dataHasilTerakhir) {
        window.location.href = "{{ route('riwayat.index') }}";
        return;
    }

    fetch("{{ route('refraksi.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: JSON.stringify(dataHasilTerakhir)
    })
    .then(() => {
        window.location.href = "{{ route('riwayat.index') }}";
    })
    .catch(() => {
        // tetap arahkan ke riwayat meski gagal simpan, agar UX tidak macet
        window.location.href = "{{ route('riwayat.index') }}";
    });
}

        // Inisialisasi awal saat halaman dimuat
        loadCharMinus();
        loadTextPlus();
    </script>
</x-app-layout>