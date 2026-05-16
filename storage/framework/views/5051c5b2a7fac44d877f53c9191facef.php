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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

        <!-- HEADER -->
        <div class="text-center space-y-3">
            <h1 class="text-3xl font-extrabold text-gray-800">
                👓 Rekomendasi Kacamata untuk Minus & Plus
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Berikut adalah rekomendasi kacamata berdasarkan tingkat gangguan penglihatan (minus dan plus).
                Setiap kategori disesuaikan dengan tingkat dioptri agar kamu bisa memilih kacamata yang tepat.
            </p>
        </div>

        <?php
        $glasses = [

            // ================= MINUS =================
            [
                'title' => 'Minus Sangat Ringan',
                'type' => 'Minus',
                'range' => '0.25 - 1.00 D',
                'desc' => 'Untuk mata dengan minus sangat ringan. Biasanya hanya terasa sedikit buram saat melihat jauh, namun masih bisa beraktivitas tanpa kacamata penuh.',
                'img' => asset('images/k1.png'),
                'color' => 'bg-green-100 text-green-700'
            ],

            [
                'title' => 'Minus Ringan',
                'type' => 'Minus',
                'range' => '1.25 - 2.00 D',
                'desc' => 'Penglihatan jarak jauh mulai terasa kabur, seperti tulisan di papan atau jalan jauh. Kacamata disarankan dipakai saat aktivitas luar ruangan atau belajar.',
                'img' => asset('images/k2.png'),
                'color' => 'bg-green-100 text-green-700'
            ],

            [
                'title' => 'Minus Sedang',
                'type' => 'Minus',
                'range' => '2.25 - 3.50 D',
                'desc' => 'Jarak jauh sudah cukup buram dan mulai mengganggu aktivitas sehari-hari. Disarankan memakai kacamata hampir sepanjang hari.',
                'img' => asset('images/k3.png'),
                'color' => 'bg-yellow-100 text-yellow-700'
            ],

            [
                'title' => 'Minus Cukup Tinggi',
                'type' => 'Minus',
                'range' => '3.75 - 5.00 D',
                'desc' => 'Penglihatan jauh sangat terbatas tanpa kacamata. Kacamata wajib digunakan untuk semua aktivitas agar tidak cepat lelah dan pusing.',
                'img' => asset('images/k4.png'),
                'color' => 'bg-orange-100 text-orange-700'
            ],

            [
                'title' => 'Minus Tinggi',
                'type' => 'Minus',
                'range' => '> 5.00 D',
                'desc' => 'Kondisi minus tinggi yang membuat penglihatan jauh sangat kabur. Penggunaan kacamata full-time sangat dianjurkan untuk menjaga kenyamanan visual.',
                'img' => asset('images/k5.png'),
                'color' => 'bg-red-100 text-red-700'
            ],

            // ================= PLUS =================
            [
                'title' => 'Plus Ringan',
                'type' => 'Plus',
                'range' => '0.25 - 1.00 D',
                'desc' => 'Kesulitan ringan saat melihat dekat seperti membaca tulisan kecil. Kacamata membantu agar mata tidak cepat lelah.',
                'img' => asset('images/k6.png'),
                'color' => 'bg-blue-100 text-blue-700'
            ],

            [
                'title' => 'Plus Ringan Menengah',
                'type' => 'Plus',
                'range' => '1.25 - 2.00 D',
                'desc' => 'Mata mulai kesulitan fokus pada jarak dekat dalam waktu lama seperti membaca atau menggunakan HP. Itu menyebabkan kegiatan anda terganggu',
                'img' => asset('images/k7.png'),
                'color' => 'bg-blue-100 text-blue-700'
            ],

            [
                'title' => 'Plus Sedang',
                'type' => 'Plus',
                'range' => '2.25 - 3.50 D',
                'desc' => 'Aktivitas jarak dekat mulai terganggu dan mata cepat lelah. Kacamata disarankan dipakai saat membaca atau bekerja.',
                'img' => asset('images/k8.png'),
                'color' => 'bg-indigo-100 text-indigo-700'
            ],

            [
                'title' => 'Plus Tinggi',
                'type' => 'Plus',
                'range' => '> 3.50 D',
                'desc' => 'Kesulitan serius dalam melihat jarak dekat tanpa bantuan kacamata. Disarankan penggunaan rutin untuk semua aktivitas dekat.',
                'img' => asset('images/k9.png'),
                'color' => 'bg-purple-100 text-purple-700'
            ],
        ];
        ?>

        <!-- GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <?php $__currentLoopData = $glasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">

                <!-- IMAGE -->
                <div class="h-52 overflow-hidden">
                    <img src="<?php echo e($item['img']); ?>"
                         alt="<?php echo e($item['title']); ?>"
                         class="w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>

                <!-- CONTENT -->
                <div class="p-5 space-y-3">

                    <div class="flex justify-between items-center">
                        <h2 class="font-bold text-lg text-gray-800">
                            <?php echo e($item['title']); ?>

                        </h2>

                        <span class="text-xs px-3 py-1 rounded-full <?php echo e($item['color']); ?>">
                            <?php echo e($item['type']); ?>

                        </span>
                    </div>

                    <p class="text-sm text-gray-500">
                        📏 Range: <span class="font-medium text-gray-700"><?php echo e($item['range']); ?></span>
                    </p>

                    <p class="text-gray-600 text-sm leading-relaxed">
                        <?php echo e($item['desc']); ?>

                    </p>

                    <button class="w-full mt-2 bg-cyan-500 hover:bg-cyan-600 text-white py-2 rounded-xl transition">
                        Lihat Detail
                    </button>

                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

        <!-- FOOTER -->
        <div class="text-center text-sm text-gray-500 pt-5">
            ⚠️ Catatan: Ini hanya rekomendasi umum. Untuk hasil yang akurat, lakukan pemeriksaan mata ke dokter atau optik terdekat.
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
<?php endif; ?><?php /**PATH D:\XampUtama\htdocs\prediksi_kondisi_mata\resources\views/kacamata.blade.php ENDPATH**/ ?>