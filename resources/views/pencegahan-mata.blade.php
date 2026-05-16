<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-10 space-y-10">

        <!-- TITLE -->
        <div class="text-center space-y-2">
            <h1 class="text-4xl font-bold text-gray-800">
                🛡️ Pencegahan Penyakit Mata
            </h1>
            <p class="text-gray-500">
                Klik judul untuk melihat penjelasan detail
            </p>
        </div>

        <!-- IMAGE -->
        <div class="overflow-hidden rounded-3xl shadow-lg">
            <img src="{{ asset('images/pencegahan.jpg') }}"
                 class="w-full object-cover max-h-[420px]">
        </div>

        <!-- INTRO -->
        <div class="bg-green-50 p-6 rounded-2xl border border-green-100">
            <p class="text-gray-700 leading-relaxed">
                Pencegahan penyakit mata merupakan bagian penting dari kesehatan umum manusia.
                Banyak gangguan penglihatan dapat dicegah sejak dini melalui kebiasaan sehari-hari yang benar,
                pola hidup sehat, serta perlindungan mata dari faktor lingkungan yang berbahaya.
            </p>
        </div>

        <!-- GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- 1 -->
            <div onclick="toggleDetail('p1')" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg cursor-pointer">
                <h2 class="font-semibold text-orange-600">🥕 Nutrisi Seimbang</h2>
                <div id="p1" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Nutrisi memiliki peran penting dalam menjaga kesehatan mata. Vitamin A membantu pembentukan pigmen retina yang berfungsi dalam penglihatan malam,
                    sementara vitamin C dan E berperan sebagai antioksidan yang melindungi sel mata dari kerusakan akibat radikal bebas.
                    Lutein dan zeaxanthin membantu melindungi retina dari cahaya biru berlebih. Kekurangan nutrisi ini dapat meningkatkan risiko gangguan seperti degenerasi makula dan rabun senja.
                </div>
            </div>

            <!-- 2 -->
            <div onclick="toggleDetail('p2')" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg cursor-pointer">
                <h2 class="font-semibold text-blue-600">📱 Atur Penggunaan Gadget</h2>
                <div id="p2" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Penggunaan gadget yang berlebihan dapat menyebabkan digital eye strain atau kelelahan mata digital.
                    Gejalanya meliputi mata kering, penglihatan kabur, dan sakit kepala. Aturan 20-20-20 sangat dianjurkan:
                    setiap 20 menit melihat layar, alihkan pandangan ke objek sejauh 20 kaki selama 20 detik.
                    Selain itu, atur kecerahan layar agar tidak terlalu tinggi dan gunakan mode malam untuk mengurangi paparan cahaya biru.
                </div>
            </div>

            <!-- 3 -->
            <div onclick="toggleDetail('p3')" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg cursor-pointer">
                <h2 class="font-semibold text-green-600">🧼 Kebersihan Mata</h2>
                <div id="p3" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Kebersihan mata sangat penting untuk mencegah infeksi seperti konjungtivitis.
                    Tangan adalah sumber utama bakteri dan virus, sehingga tidak boleh menyentuh mata sebelum mencuci tangan.
                    Penggunaan handuk, kosmetik mata, dan lensa kontak secara bergantian dengan orang lain sangat tidak dianjurkan karena dapat menularkan penyakit.
                    Membersihkan area mata secara rutin juga membantu menjaga kesehatan kelopak dan bulu mata.
                </div>
            </div>

            <!-- 4 -->
            <div onclick="toggleDetail('p4')" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg cursor-pointer">
                <h2 class="font-semibold text-purple-600">👨‍⚕️ Pemeriksaan Rutin</h2>
                <div id="p4" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Pemeriksaan mata secara rutin sangat penting meskipun tidak ada keluhan.
                    Banyak penyakit mata seperti glaukoma berkembang tanpa gejala awal yang jelas.
                    Dengan pemeriksaan berkala, dokter dapat mendeteksi perubahan tekanan mata, kondisi retina, dan refraksi sejak dini.
                    Hal ini sangat membantu dalam mencegah kerusakan penglihatan permanen yang sulit diperbaiki.
                </div>
            </div>

            <!-- 5 -->
            <div onclick="toggleDetail('p5')" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg cursor-pointer">
                <h2 class="font-semibold text-yellow-600">🕶️ Perlindungan dari Sinar UV</h2>
                <div id="p5" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Paparan sinar ultraviolet dalam jangka panjang dapat mempercepat kerusakan lensa mata dan meningkatkan risiko katarak serta pterygium.
                    Oleh karena itu, penggunaan kacamata hitam dengan perlindungan UV400 sangat dianjurkan saat berada di luar ruangan.
                    Perlindungan ini sangat penting terutama bagi orang yang sering bekerja di bawah sinar matahari langsung.
                </div>
            </div>

            <!-- 6 -->
            <div onclick="toggleDetail('p6')" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg cursor-pointer">
                <h2 class="font-semibold text-red-500">💧 Menjaga Kelembapan Mata</h2>
                <div id="p6" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Mata membutuhkan kelembapan yang cukup agar dapat berfungsi dengan baik.
                    Kondisi lingkungan seperti AC, angin kencang, atau layar komputer dapat menyebabkan mata menjadi kering.
                    Penggunaan tetes mata (artificial tears) dapat membantu menjaga kelembapan dan mengurangi rasa perih atau seperti berpasir pada mata.
                </div>
            </div>

            <!-- 7 -->
            <div onclick="toggleDetail('p7')" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg cursor-pointer">
                <h2 class="font-semibold text-indigo-600">🪑 Ergonomi & Jarak Layar</h2>
                <div id="p7" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Posisi tubuh dan jarak layar sangat mempengaruhi kesehatan mata.
                    Jarak ideal antara mata dan layar komputer adalah sekitar 50–70 cm dengan posisi layar sedikit di bawah garis pandang.
                    Posisi yang tidak ergonomis dapat menyebabkan kelelahan mata, sakit kepala, dan nyeri leher.
                </div>
            </div>

            <!-- 8 -->
            <div onclick="toggleDetail('p8')" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg cursor-pointer">
                <h2 class="font-semibold text-pink-600">🚭 Hindari Asap & Polusi</h2>
                <div id="p8" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Asap rokok dan polusi udara mengandung zat berbahaya yang dapat mengiritasi mata.
                    Paparan jangka panjang dapat memperburuk kondisi mata kering dan meningkatkan risiko peradangan.
                    Menggunakan pelindung mata atau menghindari lingkungan berpolusi dapat membantu menjaga kesehatan mata.
                </div>
            </div>

            <!-- 9 -->
            <div onclick="toggleDetail('p9')" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg cursor-pointer">
                <h2 class="font-semibold text-cyan-600">😴 Istirahat yang Cukup</h2>
                <div id="p9" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Tidur yang cukup sangat penting untuk pemulihan mata setelah aktivitas sehari-hari.
                    Kurang tidur dapat menyebabkan mata merah, bengkak, dan sulit fokus.
                    Saat tidur, mata melakukan regenerasi sel dan pemulihan fungsi visual agar tetap optimal keesokan harinya.
                </div>
            </div>

            <!-- 10 -->
            <div onclick="toggleDetail('p10')" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg cursor-pointer">
                <h2 class="font-semibold text-emerald-600">🧠 Hindari Mengucek Mata</h2>
                <div id="p10" class="hidden mt-4 text-gray-600 border-t pt-3">
                    Mengucek mata dapat menyebabkan kerusakan pada kornea, meningkatkan risiko infeksi, dan memperburuk kondisi iritasi.
                    Jika mata terasa gatal atau tidak nyaman, lebih baik menggunakan obat tetes mata steril atau berkonsultasi dengan dokter.
                </div>
            </div>

        </div>

    </div>

    <script>
        function toggleDetail(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>
</x-app-layout>