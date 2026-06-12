<x-app-layout>
    <div class="py-6 sm:py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6 sm:mb-8 text-center">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Sistem Asistensi Diagnosa Oftalmologi</h1>
                <p class="text-sm sm:text-base text-gray-600 mt-2">Klasifikasi medis berbasis Artificial Intelligence (Computer Vision) untuk deteksi patologi mata.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-2xl p-5 sm:p-8 border border-gray-100">
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
        value="{{ auth()->user()->birth_date ? \Carbon\Carbon::parse(auth()->user()->birth_date)->age : '' }}" 
        readonly
        class="w-full border-gray-200 rounded-lg bg-gray-100 shadow-sm transition-all text-sm py-2.5 cursor-not-allowed text-gray-500" 
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
                                    
                                    <div id="preview-wrapper" class="hidden relative inline-block mb-3">
                                        <img id="image-preview" class="rounded-xl max-h-48 sm:max-h-64 shadow-md border-2 border-white object-contain">
                                        
                                        <button type="button" onclick="removeImage()" class="absolute -top-3 -right-3 bg-rose-500 hover:bg-rose-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg transition-transform hover:scale-110 focus:outline-none ring-2 ring-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="webcam-container" class="hidden flex-col items-center w-full">
                                        <video id="webcam-video" class="w-full max-h-64 rounded-xl object-cover shadow-md bg-black" autoplay playsinline></video>
                                        <canvas id="webcam-canvas" class="hidden"></canvas>
                                        <div class="flex gap-2 mt-3 w-full max-w-xs">
                                            <button type="button" id="btn-capture" class="flex-1 bg-rose-600 hover:bg-rose-700 text-white py-2 rounded-xl text-sm font-bold shadow-md transition-all active:scale-95">
                                                📸 Ambil Foto
                                            </button>
                                            <button type="button" onclick="stopWebcam()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-md transition-all active:scale-95">
                                                Batal
                                            </button>
                                        </div>
                                    </div>

                                    <div id="upload-placeholder" class="text-center flex flex-col items-center w-full">
                                        <svg class="w-12 h-12 text-indigo-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="text-sm font-semibold text-gray-700 mb-4">Pilih metode unggah gambar</p>
                                        
                                        <div class="flex flex-col sm:flex-row gap-3 w-full max-w-xs mx-auto">
                                            <button type="button" onclick="triggerUpload('camera')" class="flex-1 flex items-center justify-center bg-white border-2 border-indigo-100 hover:border-indigo-400 text-indigo-700 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all active:scale-95">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" /></svg>
                                                Kamera
                                            </button>
                                            
                                            <button type="button" onclick="triggerUpload('gallery')" class="flex-1 flex items-center justify-center bg-white border-2 border-emerald-100 hover:border-emerald-400 text-emerald-700 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all active:scale-95">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                                Galeri
                                            </button>
                                        </div>
                                        <p class="text-[11px] text-gray-500 mt-4 italic px-2">Unggah foto yang jelas dan terang untuk akurasi optimal.</p>
                                    </div>

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
            <div class="absolute -top-2 -left-2 w-6 h-6 border-t-4 border-l-4 border-indigo-400 rounded-tl-lg"></div>
            <div class="absolute -top-2 -right-2 w-6 h-6 border-t-4 border-r-4 border-indigo-400 rounded-tr-lg"></div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 border-b-4 border-l-4 border-indigo-400 rounded-bl-lg"></div>
            <div class="absolute -bottom-2 -right-2 w-6 h-6 border-b-4 border-r-4 border-indigo-400 rounded-br-lg"></div>
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
        let stream = null;
        const video = document.getElementById('webcam-video');
        const canvas = document.getElementById('webcam-canvas');
        const fileInput = document.getElementById('eye_image');

        function triggerUpload(type) {
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            if (type === 'camera') {
                if (isMobile) {
                    fileInput.setAttribute('capture', 'environment');
                    fileInput.click();
                } else {
                    startWebcam();
                }
            } else {
                fileInput.removeAttribute('capture');
                fileInput.click();
            }
        }

        async function startWebcam() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
                
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('preview-wrapper').classList.add('hidden'); // Sembunyikan prev jika nyala
                document.getElementById('webcam-container').classList.remove('hidden');
                document.getElementById('webcam-container').classList.add('flex');
            } catch (err) {
                alert("Gagal mengakses kamera. Pastikan browser memiliki izin untuk menggunakan kamera laptop Anda.");
            }
        }

        function stopWebcam() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            document.getElementById('webcam-container').classList.add('hidden');
            document.getElementById('webcam-container').classList.remove('flex');
            
            // Jika tidak ada gambar yang sedang di-preview, tampilkan placeholder
            if (document.getElementById('preview-wrapper').classList.contains('hidden')) {
                document.getElementById('upload-placeholder').classList.remove('hidden');
            }
        }

        document.getElementById('btn-capture').addEventListener('click', () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            
            canvas.toBlob((blob) => {
                const file = new File([blob], "webcam_capture.jpg", { type: "image/jpeg" });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
                
                const event = new Event('change');
                fileInput.dispatchEvent(event);
                
                stopWebcam();
            }, 'image/jpeg');
        });

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    const output = document.getElementById('image-preview');
                    const scanPreview = document.getElementById('scan-preview');
                    output.src = reader.result;
                    scanPreview.src = reader.result;
                    
                    // Tampilkan wrapper gambar yang baru
                    document.getElementById('preview-wrapper').classList.remove('hidden');
                    document.getElementById('upload-placeholder').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // ========================================================
        // FUNGSI BARU: Untuk Menghapus Gambar via Tombol 'X'
        // ========================================================
        function removeImage() {
            // Kosongkan file input agar required form kembali bekerja
            fileInput.value = "";
            
            // Hapus source gambar
            document.getElementById('image-preview').src = "";
            document.getElementById('scan-preview').src = "";
            
            // Sembunyikan area preview dan tampilkan kembali tombol pilihan
            document.getElementById('preview-wrapper').classList.add('hidden');
            document.getElementById('upload-placeholder').classList.remove('hidden');
        }

        document.getElementById('form-diagnosa').onsubmit = function(e) {
            // Validasi tambahan: Pastikan form tidak dikirim jika gambar belum ada
            if(fileInput.files.length === 0) {
                alert("Silakan unggah foto mata terlebih dahulu!");
                e.preventDefault();
                return false;
            }

            document.getElementById('loading-overlay').classList.remove('hidden');
            
            const btnSubmit = document.getElementById('btn-submit');
            document.getElementById('btn-text').innerText = "Sedang Memproses AI...";
            document.getElementById('spinner').classList.remove('hidden');
            btnSubmit.classList.add('opacity-75', 'cursor-not-allowed');
            
            setTimeout(() => { btnSubmit.disabled = true; }, 50);
            return true;
        };
    </script>
</x-app-layout>