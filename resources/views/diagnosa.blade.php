<x-app-layout>
    <div class="py-6 sm:py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6 sm:mb-8 text-center">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Sistem Asistensi Diagnosa Oftalmologi</h1>
                <p class="text-sm sm:text-base text-gray-600 mt-2">Klasifikasi medis berbasis Artificial Intelligence (Computer Vision) untuk deteksi patologi mata.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-2xl p-5 sm:p-8 border border-gray-100">
                
                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-500 text-rose-600 px-4 py-3 rounded-xl mb-6 shadow-sm">
                        <strong class="font-bold text-sm">Pemeriksaan Ditolak:</strong>
                        <ul class="list-disc pl-5 mt-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('diagnosa.store') }}" method="POST" enctype="multipart/form-data" id="form-diagnosa">
                    @csrf
                    
                    <div class="flex flex-col space-y-6 sm:space-y-8">
                        
                        <div class="bg-blue-50/50 p-4 sm:p-5 rounded-xl border border-blue-100 shadow-sm">
                            <h3 class="text-blue-800 font-bold flex items-center mb-3 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Data Dasar Pasien
                            </h3>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-blue-900 uppercase italic tracking-wider">
                                    Usia Kronologis (Tahun)
                                </label>
                                <input 
                                    type="number" 
                                    name="age" 
                                    value="{{ auth()->user()->age ?? '' }}" 
                                    readonly
                                    class="w-full border-gray-200 rounded-lg shadow-sm transition-all text-sm py-2.5 bg-slate-100 text-slate-500 cursor-not-allowed select-none focus:border-gray-200 focus:ring-0" 
                                    placeholder="Usia pasien otomatis terisi"
                                    required>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label class="text-sm font-bold text-gray-700 flex items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Dokumentasi Klinis Organ Mata (WAJIB)
                            </label>
                            
                            <div class="relative group min-h-[200px] sm:min-h-[250px]">
                                <div id="preview-container" class="border-2 border-dashed border-gray-300 rounded-2xl h-full flex flex-col items-center justify-center p-6 bg-gray-50 transition-all">
                                    
                                    {{-- Preview gambar terpilih --}}
                                    <div id="preview-wrapper" class="hidden relative inline-block mb-3">
                                        <img id="image-preview" class="rounded-xl max-h-48 sm:max-h-64 shadow-md border-2 border-white object-contain">
                                        <button type="button" onclick="removeImage()" class="absolute -top-3 -right-3 bg-rose-500 hover:bg-rose-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg transition-transform hover:scale-110 focus:outline-none ring-2 ring-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Webcam container (hanya untuk desktop / browser yang support) --}}
                                    <div id="webcam-container" class="hidden flex-col items-center w-full">
                                        <video id="webcam-video" class="w-full max-h-64 rounded-xl object-cover shadow-md bg-black" autoplay playsinline></video>
                                        <canvas id="webcam-canvas" class="hidden"></canvas>

                                        {{-- Tombol switch kamera (muncul kalau ada >1 kamera) --}}
                                        <div id="switch-camera-wrapper" class="hidden mt-2">
                                            <button type="button" id="btn-switch-camera" onclick="switchCamera()" class="text-xs text-indigo-600 font-bold flex items-center gap-1 mx-auto hover:text-indigo-800 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Ganti Kamera
                                            </button>
                                        </div>

                                        <div class="flex gap-2 mt-3 w-full max-w-xs">
                                            <button type="button" id="btn-capture" class="flex-1 bg-rose-600 hover:bg-rose-700 text-white py-2 rounded-xl text-sm font-bold shadow-md transition-all active:scale-95">
                                                📸 Ambil Foto
                                            </button>
                                            <button type="button" onclick="stopWebcam()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-md transition-all active:scale-95">
                                                Batal
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Placeholder upload --}}
                                    <div id="upload-placeholder" class="text-center flex flex-col items-center w-full">
                                        <svg class="w-12 h-12 text-indigo-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="text-sm font-semibold text-gray-700 mb-4">Pilih metode unggah gambar</p>
                                        
                                        <div class="flex flex-col sm:flex-row gap-3 w-full max-w-xs mx-auto">
                                            {{-- Tombol Kamera --}}
                                            <button type="button" id="btn-open-camera" onclick="openCamera()" class="flex-1 flex items-center justify-center bg-white border-2 border-indigo-100 hover:border-indigo-400 text-indigo-700 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all active:scale-95">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                                </svg>
                                                Kamera
                                            </button>
                                            
                                            {{-- Tombol Galeri --}}
                                            <button type="button" onclick="triggerGallery()" class="flex-1 flex items-center justify-center bg-white border-2 border-emerald-100 hover:border-emerald-400 text-emerald-700 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all active:scale-95">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>
                                                Galeri
                                            </button>
                                        </div>
                                        <p class="text-[11px] text-gray-500 mt-4 italic px-2">Unggah foto yang jelas dan terang untuk akurasi optimal.</p>
                                    </div>

                                    {{-- Input file tersembunyi untuk galeri --}}
                                    <input type="file" name="eye_image" id="eye_image" class="hidden" accept="image/jpeg, image/png, image/jpg" required onchange="previewImage(event)">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-8 border-t pt-6 sm:pt-8 text-center">
                        <button type="submit" id="btn-submit" 
                            class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-8 sm:px-10 py-3.5 rounded-xl font-bold text-base sm:text-lg shadow-lg hover:shadow-indigo-200 transition-all transform hover:-translate-y-1 w-full sm:w-auto">
                            <span id="btn-text">Lakukan Analisis AI pada Gambar</span>
                            <svg id="spinner" class="animate-spin ml-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="loading-overlay" class="fixed inset-0 z-[100] hidden flex flex-col items-center justify-center bg-slate-900/90 backdrop-blur-md">
        <div class="relative">
            <div class="w-56 h-56 sm:w-64 sm:h-64 border-2 border-indigo-500 rounded-3xl overflow-hidden relative shadow-[0_0_25px_rgba(79,70,229,0.6)] bg-slate-950">
                <img id="scan-preview" class="w-full h-full object-cover opacity-60">
                <div class="absolute top-0 left-0 w-full h-1 bg-indigo-400 shadow-[0_0_15px_#818cf8] animate-scan"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-indigo-500/10 to-transparent pointer-events-none"></div>
            </div>
        </div>
        <div class="mt-8 text-center px-4">
            <h3 class="text-white text-lg sm:text-xl font-bold tracking-widest uppercase animate-pulse">Memproses Citra Medis</h3>
            <p class="text-indigo-300 text-xs sm:text-sm mt-2 italic">AI sedang mencocokkan matriks gambar dengan dataset...</p>
        </div>
    </div>

    <style>
        @keyframes scan {
            0% { top: 0%; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }
        .animate-scan { animation: scan 2.2s linear infinite; }
    </style>

    <footer class="bg-white border-t border-slate-200 pt-6 pb-12 text-center relative">
        <div class="container mx-auto px-6 text-center">
            <p class="text-slate-500 text-[10px] sm:text-xs">© 2026 <strong>Sistem Pakar Pendeteksi Gangguan Mata</strong>. Dirancang untuk edukasi dan bantuan medis berbasis komputasi.</p>
        </div>
    </footer>

    <script>
        // ============================================================
        // STATE
        // ============================================================
        let stream        = null;
        let allCameras    = [];   // daftar semua kamera yang tersedia
        let currentCamIdx = 0;   // index kamera aktif

        const video     = document.getElementById('webcam-video');
        const canvas    = document.getElementById('webcam-canvas');
        const fileInput = document.getElementById('eye_image');

        // ============================================================
        // DETEKSI PERANGKAT
        // ============================================================
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

        // ============================================================
        // ENUMERATE CAMERAS — deteksi berapa kamera tersedia
        // ============================================================
        async function enumerateCameras() {
            try {
                const devices = await navigator.mediaDevices.enumerateDevices();
                allCameras = devices.filter(d => d.kind === 'videoinput');
            } catch (e) {
                allCameras = [];
            }
        }

        // ============================================================
        // BUKA KAMERA
        // Logika:
        //   Mobile  → default kamera DEPAN (user) untuk foto mata sendiri
        //   Desktop → pakai kamera default (biasanya webcam built-in)
        //   Fallback → kalau facingMode tidak support, coba tanpa constraint
        // ============================================================
        async function openCamera() {
            await enumerateCameras();

            // Tentukan facingMode awal
            // Mobile default depan, desktop default apapun yang tersedia
            const facingMode = isMobile ? 'user' : undefined;
            await startStream(facingMode);
        }

        async function startStream(facingMode) {
            // Stop stream lama kalau ada
            if (stream) {
                stream.getTracks().forEach(t => t.stop());
                stream = null;
            }

            const constraints = { video: facingMode ? { facingMode } : true };

            try {
                stream = await navigator.mediaDevices.getUserMedia(constraints);
            } catch (e) {
                // Fallback: coba tanpa facingMode kalau gagal
                try {
                    stream = await navigator.mediaDevices.getUserMedia({ video: true });
                } catch (e2) {
                    alert('Gagal mengakses kamera. Pastikan browser memiliki izin kamera.');
                    return;
                }
            }

            video.srcObject = stream;

            // Tampilkan tombol switch kamera hanya kalau ada lebih dari 1 kamera (umumnya mobile)
            const switchWrapper = document.getElementById('switch-camera-wrapper');
            if (allCameras.length > 1) {
                switchWrapper.classList.remove('hidden');
            } else {
                switchWrapper.classList.add('hidden');
            }

            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('preview-wrapper').classList.add('hidden');
            document.getElementById('webcam-container').classList.remove('hidden');
            document.getElementById('webcam-container').classList.add('flex');
        }

        // ============================================================
        // SWITCH KAMERA (toggle depan ↔ belakang di mobile)
        // ============================================================
        async function switchCamera() {
            if (allCameras.length <= 1) return;

            // Toggle facing mode berdasarkan track aktif saat ini
            const currentTrack = stream && stream.getVideoTracks()[0];
            const currentFacing = currentTrack?.getSettings()?.facingMode;
            const nextFacing    = currentFacing === 'user' ? 'environment' : 'user';

            const btn = document.getElementById('btn-switch-camera');
            btn.disabled    = true;
            btn.textContent = 'Mengganti...';

            await startStream(nextFacing);

            btn.disabled    = false;
            btn.innerHTML   = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> Ganti Kamera`;
        }

        // ============================================================
        // STOP WEBCAM
        // ============================================================
        function stopWebcam() {
            if (stream) {
                stream.getTracks().forEach(t => t.stop());
                stream = null;
            }
            document.getElementById('webcam-container').classList.add('hidden');
            document.getElementById('webcam-container').classList.remove('flex');

            if (document.getElementById('preview-wrapper').classList.contains('hidden')) {
                document.getElementById('upload-placeholder').classList.remove('hidden');
            }
        }

        // ============================================================
        // AMBIL FOTO DARI WEBCAM
        // ============================================================
        document.getElementById('btn-capture').addEventListener('click', () => {
            canvas.width  = video.videoWidth;
            canvas.height = video.videoHeight;

            const ctx = canvas.getContext('2d');

            // Mirror gambar kalau kamera depan (facingMode: user) agar tidak terbalik
            const currentTrack  = stream && stream.getVideoTracks()[0];
            const currentFacing = currentTrack?.getSettings()?.facingMode;
            if (currentFacing === 'user' || (!isMobile)) {
                ctx.translate(canvas.width, 0);
                ctx.scale(-1, 1);
            }
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob((blob) => {
                const file = new File([blob], 'webcam_capture.jpg', { type: 'image/jpeg' });
                const dt   = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;

                const event = new Event('change');
                fileInput.dispatchEvent(event);

                stopWebcam();
            }, 'image/jpeg', 0.92);
        });

        // ============================================================
        // BUKA GALERI (input file biasa)
        // ============================================================
        function triggerGallery() {
            fileInput.removeAttribute('capture');
            fileInput.click();
        }

        // ============================================================
        // PREVIEW GAMBAR DARI GALERI
        // ============================================================
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function () {
                document.getElementById('image-preview').src  = reader.result;
                document.getElementById('scan-preview').src   = reader.result;
                document.getElementById('preview-wrapper').classList.remove('hidden');
                document.getElementById('upload-placeholder').classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        // ============================================================
        // HAPUS GAMBAR
        // ============================================================
        function removeImage() {
            fileInput.value = '';
            document.getElementById('image-preview').src = '';
            document.getElementById('scan-preview').src  = '';
            document.getElementById('preview-wrapper').classList.add('hidden');
            document.getElementById('upload-placeholder').classList.remove('hidden');
        }

        // ============================================================
        // SUBMIT FORM
        // ============================================================
        document.getElementById('form-diagnosa').onsubmit = function (e) {
            if (fileInput.files.length === 0) {
                alert('Silakan unggah foto mata terlebih dahulu!');
                e.preventDefault();
                return false;
            }

            document.getElementById('loading-overlay').classList.remove('hidden');
            document.getElementById('btn-text').innerText = 'Sedang Memproses AI...';
            document.getElementById('spinner').classList.remove('hidden');
            document.getElementById('btn-submit').classList.add('opacity-75', 'pointer-events-none');

            return true;
        };
    </script>
</x-app-layout>