<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                
                <?php
                    $isGagal = ($class === 'Diagnosa Gagal' || $class === 'Bukan Mata');
                    $headerBg = 'from-slate-800 to-slate-900'; 
                    $headerIcon = 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z';

                    if ($isGagal) {
                        $headerBg = 'from-amber-500 to-amber-600';
                        $headerIcon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                    } elseif ($class === 'Mata Normal') {
                        $headerBg = 'from-emerald-500 to-emerald-600';
                        $headerIcon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                    } elseif ($class === 'Katarak' || $class === 'Glaukoma' || str_contains($class, 'Iritasi')) {
                        $headerBg = 'from-rose-500 to-rose-600';
                        $headerIcon = 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z';
                    }
                ?>

                <div class="bg-gradient-to-r <?php echo e($headerBg); ?> px-8 py-6 text-white flex items-center space-x-4">
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($headerIcon); ?>" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-white/80 uppercase">Computer Vision & Expert System</p>
                        <h2 class="text-2xl font-black tracking-tight">Lembar Hasil Screening</h2>
                    </div>
                </div>

                <div class="p-8 space-y-6">
                    
                    <div class="grid grid-cols-2 gap-4 bg-gray-50 p-5 rounded-xl border border-gray-100">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Kesimpulan Akhir</span>
                            <span class="text-xl font-extrabold text-gray-900"><?php echo e($class); ?></span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Tingkat Keyakinan (CF)</span>
                            <span class="text-xl font-extrabold text-indigo-600"><?php echo e($confidence); ?>%</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Interpretasi & Edukasi Medis
                        </h4>

                        <?php if($class === 'Diagnosa Gagal' || $class === 'Bukan Mata'): ?>
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Sistem gagal mengonfirmasi keberadaan komponen organ bola mata atau struktur pembuluh darah retina dari gambar yang diunggah.</p>
                                <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl">
                                    <h5 class="text-sm font-bold text-amber-900 flex items-center mb-2">
                                        ⚠️ Cara Pengambilan Gambar yang Benar:
                                    </h5>
                                    <ul class="text-xs text-amber-900/90 space-y-2 list-disc pl-4">
                                        <li><strong>Fokus Saraf Mata:</strong> Pastikan gambar tajam (tidak blur) dan fokus menangkap bulatan retina.</li>
                                        <li><strong>Hindari Refleksi Cahaya:</strong> Singkirkan pantulan cahaya lampu atau blitz kilat yang berlebih di tengah lensa mata.</li>
                                        <li><strong>Citra Digital Asli:</strong> Gunakan file citra biner asli, hindari memotret ulang hasil cetakan kertas atau layar monitor komputer lain.</li>
                                    </ul>
                                </div>
                            </div>

                        <?php elseif($class === 'Mata Normal'): ?>
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Hasil screening menunjukkan komponen optik mata Anda berada dalam kondisi batas fisiologis normal. Tidak terdeteksi tanda-tanda kerusakan struktural akibat katarak ataupun penyempitan cakram optik (glaukoma).</p>
                                <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-xl text-emerald-900">
                                    <h5 class="text-sm font-bold mb-1">💡 Saran Perawatan Preventif:</h5>
                                    <p class="text-xs leading-relaxed">Terapkan prinsip istirahat mata 20-20-20 saat bekerja dengan komputer, pertahankan asupan nutrisi kaya antioksidan (Lutein, Vitamin A), serta lakukan kontrol rutin minimal setahun sekali.</p>
                                </div>
                            </div>

                        <?php elseif($class === 'Katarak'): ?>
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Sistem mendeteksi adanya intensitas kekeruhan lensa refraksi di dalam media mata Anda. Kondisi ini menyerupai gejala perkembangan awal penumpukan makromolekul protein lensa katarak.</p>
                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl space-y-2">
                                    <h5 class="text-sm font-bold text-gray-700">📋 Tindakan Kelanjutan:</h5>
                                    <p class="text-xs text-gray-600 leading-relaxed">1. Jadwalkan pemeriksaan diagnostic fisik menggunakan perangkat <strong>Slit-lamp examination</strong> ke Dokter Spesialis Mata (Sp.M).</p>
                                    <p class="text-xs text-gray-600 leading-relaxed">2. Lindungi kornea dari pajaran sinar UV luar ruangan menggunakan kacamata gelap pelindung untuk memperlambat maturitas katarak.</p>
                                </div>
                            </div>

                        <?php elseif($class === 'Glaukoma'): ?>
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Sistem mendeteksi deviasi kelainan struktural pada dimensi *Cup-to-Disc Ratio* kepala saraf optik, yang merupakan indikasi klinis awal penyakit Glaukoma.</p>
                                <div class="bg-rose-50 border border-rose-200 p-4 rounded-xl space-y-2">
                                    <h5 class="text-sm font-bold text-rose-900">🚨 Peringatan Penting:</h5>
                                    <p class="text-xs text-rose-900/90 leading-relaxed font-semibold">Glaukoma sering berkembang tanpa disertai gejala rasa nyeri di fase awal awal. Deteksi dini sangat vital untuk mencegah penyempitan lapang pandang permanen.</p>
                                    <p class="text-xs text-rose-800 leading-relaxed">Disarankan segera melakukan tes <strong>Tonometri</strong> (pengukuran tekanan intraokular bola mata) dan uji lapang pandang di fasilitas kesehatan mata terdekat.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex space-x-3">
                        <a href="<?php echo e(route('diagnosa.index')); ?>" class="flex-1 bg-slate-900 text-white font-bold py-3.5 px-4 rounded-xl hover:bg-slate-800 transition-all text-sm text-center shadow-md">
                            🔄 Lakukan Diagnosa Ulang
                        </a>
                        <button onclick="window.print()" class="bg-gray-100 text-gray-700 font-bold py-3.5 px-6 rounded-xl hover:bg-gray-200 transition-all text-sm flex items-center">
                            🖨️ Cetak Hasil
                        </button>
                    </div>

                </div>
            </div>
            
            <p class="text-[10px] text-gray-400 text-center mt-6 leading-relaxed px-4">
                *Pemberitahuan: Sistem asistensi ini menggunakan pemrosesan kecerdasan buatan (AI) sebagai instrumen penapisan dini risiko klinis mandiri. Hasil ini bukan merupakan vonis pengganti diagnosis rekam medis dari dokter spesialis mata.
            </p>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\XampUtama\htdocs\prediksi_kondisi_mata\resources\views/diagnosa_hasil.blade.php ENDPATH**/ ?>