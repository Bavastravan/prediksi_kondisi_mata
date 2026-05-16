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
    <div class="max-w-6xl mx-auto px-6 py-10 space-y-10">

        <!-- TITLE -->
        <div class="text-center space-y-2">
            <h1 class="text-4xl font-bold text-gray-800">
                🦠 Penyakit Mata
            </h1>
            <p class="text-gray-500">
                Klik judul untuk melihat penjelasan detail
            </p>
        </div>

        <!-- IMAGE -->
        <div class="relative rounded-3xl overflow-hidden shadow-xl h-[500px]">
            <img src="<?php echo e(asset('images/penyakit.jpg')); ?>"
                 class="w-full h-full object-cover">
            
        </div>

        <!-- INTRO -->
        <div class="bg-red-50 p-6 rounded-2xl border border-red-100">
            <p class="text-gray-700 leading-relaxed">
                Penyakit mata merupakan gangguan pada struktur atau fungsi organ penglihatan yang dapat disebabkan oleh infeksi,
                faktor usia, kelainan refraksi, trauma, maupun penyakit sistemik.
            </p>
        </div>

        <!-- GRID -->
        <div class="grid md:grid-cols-2 gap-6">

            <!-- 1 -->
            <div onclick="toggleDetail('d1')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-pink-600">🦠 Konjungtivitis</h2>
                <div id="d1" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Konjungtivitis adalah peradangan pada konjungtiva (selaput tipis mata).
                    Kondisi ini menyebabkan mata merah, berair, dan gatal. Penyebab utama adalah infeksi virus, bakteri, atau alergi.
                </div>
            </div>

            <!-- 2 -->
            <div onclick="toggleDetail('d2')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-gray-700">👁️ Katarak</h2>
                <div id="d2" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Katarak adalah kekeruhan pada lensa mata yang menyebabkan penglihatan buram dan silau.
                    Umumnya terjadi pada usia lanjut, tetapi juga bisa dipicu diabetes atau paparan UV.
                </div>
            </div>

            <!-- 3 -->
            <div onclick="toggleDetail('d3')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-green-600">📈 Glaukoma</h2>
                <div id="d3" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Glaukoma adalah kerusakan saraf optik akibat tekanan bola mata meningkat.
                    Penyakit ini dapat menyebabkan kebutaan permanen jika tidak ditangani.
                </div>
            </div>

            <!-- 4 -->
            <div onclick="toggleDetail('d4')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-blue-600">👓 Miopia</h2>
                <div id="d4" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Miopia adalah rabun jauh, di mana objek jauh terlihat buram.
                    Disebabkan bentuk bola mata terlalu panjang atau kornea terlalu melengkung.
                </div>
            </div>

            <!-- 5 -->
            <div onclick="toggleDetail('d5')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-purple-600">🧬 Pterygium</h2>
                <div id="d5" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Pterygium adalah pertumbuhan jaringan pada konjungtiva yang dapat menutupi kornea.
                    Penyebab utama adalah paparan sinar UV, debu, dan angin.
                </div>
            </div>

            <!-- 6 -->
            <div onclick="toggleDetail('d6')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-red-500">🌞 Fotofobia</h2>
                <div id="d6" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Fotofobia adalah sensitivitas berlebihan terhadap cahaya.
                    Biasanya merupakan gejala infeksi mata, migrain, atau peradangan.
                </div>
            </div>

            <!-- 7 -->
            <div onclick="toggleDetail('d7')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-indigo-600">💧 Mata Kering</h2>
                <div id="d7" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Mata kering terjadi karena produksi air mata tidak cukup.
                    Menyebabkan rasa perih, seperti berpasir, dan mudah lelah.
                </div>
            </div>

            <!-- 8 -->
            <div onclick="toggleDetail('d8')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-orange-600">🌫️ Penglihatan Berkabut</h2>
                <div id="d8" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Penglihatan berkabut membuat objek terlihat buram seperti tertutup kabut.
                    Penyebabnya bisa katarak awal atau gangguan refraksi.
                </div>
            </div>

            <!-- 9 -->
            <div onclick="toggleDetail('d9')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-cyan-600">👁️ Astigmatisma</h2>
                <div id="d9" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Astigmatisma adalah kelainan bentuk kornea yang tidak sempurna.
                    Menyebabkan penglihatan kabur di semua jarak.
                </div>
            </div>

            <!-- 10 -->
            <div onclick="toggleDetail('d10')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-emerald-600">⚡ Diplopia</h2>
                <div id="d10" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Diplopia adalah kondisi melihat dua bayangan dari satu objek.
                    Penyebabnya bisa gangguan saraf, otot mata, atau trauma kepala.
                </div>
            </div>

        </div>

        <!-- WARNING -->
        <div class="text-sm text-gray-500 text-center">
            ⚠️ Segera konsultasi ke dokter jika gejala semakin parah atau mengganggu penglihatan.
        </div>

    </div>

    <!-- SCRIPT TOGGLE -->
    <script>
        function toggleDetail(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\XampUtama\htdocs\prediksi_kondisi_mata\resources\views/penyakit-mata.blade.php ENDPATH**/ ?>