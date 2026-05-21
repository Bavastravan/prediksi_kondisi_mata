<x-app-layout>
    <div class="py-12 bg-slate-900 min-h-screen text-slate-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-black text-white tracking-tight">Skrining Persepsi Buta Warna (Ishihara Advanced Draw)</h1>
                <p class="text-slate-400 text-sm mt-2">Kombinasi metode Teoretis Angka Klinis dan Interaksi Menggambar Menghubungkan Lintasan Jalur.</p>
            </div>

            <div class="bg-slate-800 rounded-3xl p-8 border border-slate-700 shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <div class="space-y-4 md:col-span-1 bg-slate-800/50 p-5 rounded-2xl border border-slate-700/60 flex flex-col justify-between">
                        <div>
                            <div class="inline-flex bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 border border-emerald-500/20">Canvas Path Tracking</div>
                            <h2 class="text-base font-bold text-white">Aturan Skrining:</h2>
                            <p id="panduan-teks" class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Fokuskan mata Anda pada piringan spektrum warna di sebelah kanan. Ketik pola angka tersembunyi yang Anda lihat, lalu klik Kirim.
                            </p>
                        </div>
                        <div class="pt-4 border-t border-slate-700">
                            <div class="text-xs font-bold text-slate-300 uppercase mb-2 flex justify-between">
                                <span>Kemajuan Ujian:</span>
                                <span id="ishihara-step">Piringan 1/5</span>
                            </div>
                            <div class="w-full bg-slate-700 h-2 rounded-full overflow-hidden">
                                <div id="ishihara-bar" class="bg-emerald-500 h-full transition-all duration-300" style="width: 20%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 flex flex-col items-center justify-center bg-slate-950 rounded-2xl border-2 border-slate-700 p-8 min-h-[380px]">
                        
                        <div id="plate-circle" class="w-64 h-64 rounded-full border-4 border-slate-700 overflow-hidden shadow-2xl flex items-center justify-center p-0 relative transition-all duration-300 select-none">
                            
                            <canvas id="ishiharaCanvas" width="250" height="250" class="absolute inset-0 cursor-crosshair z-20"></canvas>
                            
                            <div id="text-target-box" class="absolute inset-0 flex items-center justify-center z-10 font-mono font-black text-7xl select-none blur-[1px]"></div>
                        </div>

                        <div id="panel-angka" class="mt-6 flex space-x-2 w-full max-w-xs">
                            <input type="number" id="input-angka" placeholder="Angka berapa?" class="flex-1 bg-slate-800 border-slate-600 rounded-xl text-white text-center font-bold text-base focus:ring-emerald-500 focus:border-emerald-500 py-2.5">
                            <button onclick="verifikasiAngka()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 rounded-xl text-sm transition-all shadow-md active:scale-95">Kirim</button>
                        </div>

                        <div id="panel-drawing" class="mt-6 hidden w-full max-w-xs flex flex-col items-center gap-2">
                            <div class="flex gap-2 w-full">
                                <button onclick="clearCanvas()" class="flex-1 bg-slate-800 hover:bg-slate-700 border border-slate-600 text-slate-300 py-2.5 rounded-xl text-xs font-bold transition">Hapus Coretan</button>
                                <button onclick="verifikasiJalur()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg active:scale-95">Kunci & Validasi</button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="modal-hasil" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center hidden p-4 transition-all duration-300">
        <div class="bg-slate-800 border-2 border-slate-700 rounded-3xl p-6 max-w-sm w-full shadow-2xl text-center max-h-[95vh] overflow-y-auto">
            
            <div class="w-14 h-14 bg-emerald-500/10 text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-3 border border-emerald-500/30 shadow-inner shrink-0">
                <i class="fa-solid fa-clipboard-check text-2xl"></i>
            </div>
            
            <h3 class="text-lg font-black text-white uppercase tracking-wider">Lembar Evaluasi Warna</h3>
            <p class="text-slate-400 text-[11px] mt-1">Hasil kalkulasi sistem berdasarkan data input klinis</p>
            
            <div class="my-4 p-4 bg-slate-950 rounded-2xl border border-slate-700 text-left space-y-3 shadow-inner">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-400">Modul Skrining:</span>
                    <span class="font-bold text-slate-200 bg-slate-800 px-2 py-1 rounded-md border border-slate-700/60 text-[11px]">Ishihara Path Analysis</span>
                </div>
                
                <div class="flex justify-between items-center text-sm pt-1">
                    <span class="text-slate-400">Total Benar:</span>
                    <span id="res-color-score" class="font-black text-emerald-400 text-base font-mono">0 dari 5 Benar</span>
                </div>
                
                <div class="mt-2 pt-2 border-t border-slate-800 flex flex-col gap-1.5">
                    <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Status Kebutaan Warna:</span>
                    <div class="bg-emerald-950/40 border border-emerald-500/40 rounded-xl p-2.5 shadow-inner">
                        <span id="res-color-kesimpulan" class="font-extrabold text-xs text-emerald-300 leading-relaxed block text-center">
                            -
                        </span>
                    </div>
                </div>
            </div>

            <div class="mb-4 p-3.5 bg-slate-900/80 border border-slate-700/80 rounded-xl text-left shadow-inner flex flex-col gap-1.5">
                <h4 class="text-[10px] font-bold uppercase tracking-widest text-emerald-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-lightbulb text-amber-400"></i> Saran Tindak Lanjut
                </h4>
                <p id="res-tindak-lanjut" class="text-[11px] text-slate-300 leading-relaxed opacity-90">
                    Memuat rekomendasi...
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-2 shrink-0">
                <button onclick="window.location.reload()" class="bg-slate-700 hover:bg-slate-600 active:scale-95 text-slate-200 font-bold py-2.5 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 border border-slate-600 shadow-md">
                    <i class="fa-solid fa-rotate-right text-slate-400"></i> Uji Ulang
                </button>
                <a href="{{ route('diagnosa.index') }}" class="bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white font-bold py-2.5 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 shadow-lg shadow-emerald-950/30">
                    <i class="fa-solid fa-circle-check"></i> Kembali
                </a>
            </div>
            
        </div>
    </div>
    <script>
        let step = 0;
        let score = 0;

        const canvas = document.getElementById('ishiharaCanvas');
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let userPoints = [];

        // 🧠 DATASET SPEKTRUM WARNA ISHIHARA
        const plates = [
            { type: 'angka', ans: 12, bg: 'linear-gradient(135deg, #ca8a04, #eab308)', color: 'rgba(255,255,255,0.2)' },
            { type: 'angka', ans: 74, bg: 'linear-gradient(135deg, #059669, #10b981)', color: 'rgba(255,255,255,0.2)' },
            { type: 'angka', ans: 6,  bg: 'linear-gradient(135deg, #e11d48, #f43f5e)', color: 'rgba(255,255,255,0.2)' },
            
            // Piringan Jalur Kelok (Tracing Plates)
            { type: 'jalur', bg: 'linear-gradient(135deg, #b45309, #d97706)', checkFunction: (x) => 50 * Math.sin(x / 35) + 125 }, 
            { type: 'jalur', bg: 'linear-gradient(135deg, #0284c7, #38bdf8)', checkFunction: (x) => 0.003 * Math.pow(x - 125, 3) + 125 } 
        ];

        function loadPlate() {
            const container = document.getElementById('plate-circle');
            const textBox = document.getElementById('text-target-box');
            const panelAngka = document.getElementById('panel-angka');
            const panelDrawing = document.getElementById('panel-drawing');
            const panduanTeks = document.getElementById('panduan-teks');

            container.style.background = plates[step].bg;
            clearCanvas();

            if (plates[step].type === 'angka') {
                panelAngka.classList.remove('hidden');
                panelDrawing.classList.add('hidden');
                panduanTeks.innerText = "Fokuskan mata Anda pada lingkaran penuh warna di samping. Ketik kombinasi angka tersembunyi yang Anda lihat, lalu klik Kirim.";
                
                textBox.innerHTML = plates[step].ans;
                textBox.style.color = plates[step].color;
                document.getElementById('input-angka').value = "";
                document.getElementById('input-angka').focus();
            } else {
                panelAngka.classList.add('hidden');
                panelDrawing.classList.remove('hidden');
                textBox.innerHTML = ""; 
                panduanTeks.innerHTML = "✨ <strong>Modul Tracing Jalur Berkelok</strong>. Hubungkan titik-titik samar berkelok yang melintasi lingkaran warna dari ujung <span class='text-amber-400 font-bold'>KIRI ke KANAN</span> menggunakan klik-tahan mouse atau usapan jari Anda.";
                
                drawHiddenPath();
            }
        }

        function drawHiddenPath() {
            ctx.beginPath();
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.28)';
            ctx.lineWidth = 14;
            ctx.setLineDash([2, 18]);
            ctx.lineCap = 'round';

            for (let x = 10; x <= 240; x += 5) {
                let y = plates[step].checkFunction(x);
                if (x === 10) ctx.moveTo(x, y);
                else ctx.lineTo(x, y);
            }
            ctx.stroke();
            ctx.setLineDash([]);
        }

        function getMousePos(e) {
            const rect = canvas.getBoundingClientRect();
            return {
                x: (e.clientX || e.touches[0].clientX) - rect.left,
                y: (e.clientY || e.touches[0].clientY) - rect.top
            };
        }

        function startDrawing(e) {
            if (plates[step].type === 'angka') return;
            isDrawing = true;
            userPoints = [];
            ctx.beginPath();
            const pos = getMousePos(e);
            ctx.moveTo(pos.x, pos.y);
            ctx.strokeStyle = '#f43f5e';
            ctx.lineWidth = 4;
            ctx.lineJoin = 'round';
            ctx.lineCap = 'round';
        }

        function draw(e) {
            if (!isDrawing) return;
            e.preventDefault();
            const pos = getMousePos(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            userPoints.push(pos);
        }

        function stopDrawing() { isDrawing = false; }

        function clearCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            userPoints = [];
            if (plates[step] && plates[step].type === 'jalur') drawHiddenPath();
        }

        function verifikasiJalur() {
            if (userPoints.length < 15) {
                alert("Coretan Anda terlalu pendek. Hubungkan garis dari ujung kiri hingga kanan!");
                return;
            }

            let matchCount = 0;
            userPoints.forEach(p => {
                let idealY = plates[step].checkFunction(p.x);
                let selisihJarak = Math.abs(p.y - idealY);
                if (selisihJarak <= 25) matchCount++;
            });

            let tingkatAkurasiCoretan = matchCount / userPoints.length;

            if (tingkatAkurasiCoretan >= 0.60) {
                score++;
            }
            lanjutStep();
        }

        function verifikasiAngka() {
            const guess = parseInt(document.getElementById('input-angka').value);
            if (guess === plates[step].ans) score++;
            lanjutStep();
        }

        function lanjutStep() {
            step++;
            if (step < plates.length) {
                document.getElementById('ishihara-step').innerText = `Piringan ${step + 1}/5`;
                document.getElementById('ishihara-bar').style.width = ((step + 1) / 5 * 100) + "%";
                loadPlate();
            } else {
                // Proses Kesimpulan & Nilai
                document.getElementById('res-color-score').innerText = `${score} dari 5 Benar`;
                let msg = (score === 5) ? "Visi Warna Normal (Trichromacy Sempurna)" : (score >= 3) ? "Indikasi Buta Warna Parsial (Anomalous Trichromacy)" : "Defisiensi Spektrum Warna Tinggi (Protanopia/Deuteranopia Berat)";
                document.getElementById('res-color-kesimpulan').innerText = msg;

                // 🧠 LOGIKA REKOMENDASI TINDAK LANJUT BUTA WARNA
                let rekomendasiText = "";
                if (score === 5) {
                    rekomendasiText = "Penglihatan spektrum warna Anda sempurna. Tidak diperlukan tindakan medis khusus. Jaga kesehatan sel kerucut (cone cell) retina dengan asupan nutrisi seimbang.";
                } else if (score >= 3) {
                    rekomendasiText = "Terdeteksi defisiensi warna parsial. Anda dapat mencoba mengaktifkan fitur 'Aksesibilitas Filter Warna' pada pengaturan layar Smartphone/Laptop Anda untuk membantu membedakan kontras warna digital.";
                } else {
                    rekomendasiText = "Konsultasikan dengan Dokter Spesialis Mata atau Refraksionis Optisien Anda terkait ketersediaan 'Lensa Kacamata Khusus Buta Warna' (seperti lensa berlapis tinted) untuk membantu diskriminasi warna saat beraktivitas.";
                }
                document.getElementById('res-tindak-lanjut').innerText = rekomendasiText;

                // Tampilkan Modal
                document.getElementById('modal-hasil').classList.remove('hidden');
            }
        }

        // Pasang Event Canvas
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        
        canvas.addEventListener('touchstart', startDrawing, { passive: false });
        canvas.addEventListener('touchmove', draw, { passive: false });
        canvas.addEventListener('touchend', stopDrawing);

        loadPlate();
    </script>
</x-app-layout>