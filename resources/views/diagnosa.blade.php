<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Sistem Asistensi Diagnosa Oftalmologi</h1>
                <p class="text-gray-600 mt-2">Integrasi teknologi komputasi medis untuk deteksi dini anomali pada kesehatan mata.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-gray-100">
                <form action="{{ route('diagnosa.store') }}" method="POST" enctype="multipart/form-data" id="form-diagnosa">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <div class="space-y-6">
                            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 shadow-sm">
                                <h3 class="text-blue-800 font-bold flex items-center mb-3 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Anamnesa Pasien
                                </h3>
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-blue-900 uppercase italic tracking-wider">Usia Kronologis</label>
                                    <input type="number" name="age" placeholder="Masukkan usia dalam tahun" 
                                        class="w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-all text-sm italic py-2" required>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="text-sm font-bold text-gray-700 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Manifestasi Klinis (Gejala Pasien)
                                </label>
                                
                                <div class="grid grid-cols-1 gap-2 max-h-[260px] overflow-y-auto pr-2 custom-scrollbar">
                                    @php
                                        $gejala = [
                                            ['val' => 'kabur',        'label' => 'Penurunan Visus (Pandangan Kabur)'],
                                            ['val' => 'selaput',      'label' => 'Lensa Mengeruh / Ada Selaput Putih (Katarak)'],
                                            ['val' => 'merah',        'label' => 'Injeksi Silier / Konjungtiva (Mata Merah)'],
                                            ['val' => 'lengket',      'label' => 'Eksudat Lengket / Kelopak Menempel Bangun Pagi'],
                                            ['val' => 'benjolan',     'label' => 'Hordeolum (Benjolan Bengkak & Nyeri di Kelopak)'],
                                            ['val' => 'silau',        'label' => 'Fotofobia (Sangat Sensitif/Silau Cahaya)'],
                                            ['val' => 'pupil_aneh',   'label' => 'Deformitas Pupil (Bentuk Pupil Tidak Teratur)'],
                                            ['val' => 'nyeri',        'label' => 'Ocular Pain (Mata Terasa Cekot-cekot / Nyeri Tekan)'],
                                        ];
                                    @endphp

                                    @foreach($gejala as $g)
                                    <label class="flex items-center p-2.5 border border-gray-100 rounded-xl cursor-pointer hover:bg-indigo-50 transition-colors group bg-white shadow-sm">
                                        <input type="checkbox" name="symptoms[]" value="{{ $g['val'] }}" 
                                            class="rounded text-indigo-600 focus:ring-indigo-500 border-gray-300 h-4 w-4">
                                        <span class="ml-3 text-gray-700 group-hover:text-indigo-700 transition-colors text-xs font-medium">{{ $g['label'] }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col h-full justify-between">
                            <div class="flex flex-col flex-1">
                                <label class="text-sm font-bold text-gray-700 flex items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Dokumentasi Klinis Organ Mata
                                </label>
                                
                                <div class="relative flex-1 group min-h-[300px]">
                                    <div id="preview-container" class="border-2 border-dashed border-gray-300 rounded-2xl h-full flex flex-col items-center justify-center p-6 bg-gray-50 group-hover:bg-gray-100 transition-all group-hover:border-indigo-400">
                                        <img id="image-preview" class="hidden mb-4 rounded-lg max-h-52 shadow-md border-2 border-white object-cover">
                                        <svg id="upload-icon" class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="text-center text-sm text-gray-500 px-4 italic">Unggah citra medis mata untuk analisis komputasi otomatis</p>
                                        <input type="file" name="eye_image" accept="image/*" id="eye_image" class="absolute inset-0 opacity-0 cursor-pointer" required onchange="previewImage(event)">
                                    </div>
                                </div>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2 leading-tight">*Kualitas citra yang jernih secara klinis krusial untuk presisi analisis sistem.</p>
                        </div>
                    </div>

                    <div class="mt-8 border-t pt-6 text-center">
                        <button type="submit" id="btn-submit" 
                            class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-12 py-3.5 rounded-2xl font-bold text-lg shadow-lg hover:shadow-indigo-200 transition-all transform hover:-translate-y-1">
                            <span id="btn-text">Lakukan Proses Screening Medis</span>
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
            <div class="w-64 h-64 border-2 border-indigo-500 rounded-3xl overflow-hidden relative shadow-[0_0_25px_rgba(79,70,229,0.6)] bg-slate-950">
                <img id="scan-preview" class="w-full h-full object-cover opacity-60">
                <div class="absolute top-0 left-0 w-full h-1 bg-indigo-400 shadow-[0_0_15px_#818cf8] animate-scan"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-indigo-500/10 to-transparent pointer-events-none"></div>
            </div>
            <div class="absolute -top-2 -left-2 w-6 h-6 border-t-4 border-l-4 border-indigo-400 rounded-tl-lg"></div>
            <div class="absolute -top-2 -right-2 w-6 h-6 border-t-4 border-r-4 border-indigo-400 rounded-tr-lg"></div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 border-b-4 border-l-4 border-indigo-400 rounded-bl-lg"></div>
            <div class="absolute -bottom-2 -right-2 w-6 h-6 border-b-4 border-r-4 border-indigo-400 rounded-br-lg"></div>
        </div>
        <div class="mt-8 text-center">
            <h3 class="text-white text-xl font-bold tracking-widest uppercase animate-pulse">Sistem Sedang Memproses Data</h3>
            <p class="text-indigo-300 text-sm mt-2 italic">Mengidentifikasi matriks citra patologi ocular via AI engine...</p>
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
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    </style>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    const output = document.getElementById('image-preview');
                    const scanPreview = document.getElementById('scan-preview');
                    const icon = document.getElementById('upload-icon');
                    output.src = reader.result;
                    scanPreview.src = reader.result;
                    output.classList.remove('hidden');
                    icon.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        document.getElementById('form-diagnosa').onsubmit = function() {
            document.getElementById('loading-overlay').classList.remove('hidden');
            document.getElementById('btn-text').innerText = "Sedang Menganalisis...";
            document.getElementById('spinner').classList.remove('hidden');
            const btnSubmit = document.getElementById('btn-submit');
            btnSubmit.classList.add('opacity-75', 'cursor-not-allowed');
            setTimeout(() => { btnSubmit.disabled = true; }, 50);
            return true;
        };
    </script>
</x-app-layout>