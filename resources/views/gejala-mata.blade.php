<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-10 space-y-10">

        <!-- TITLE -->
        <div class="text-center space-y-2">
            <h1 class="text-4xl font-bold text-gray-800">👁️ Gejala Penyakit Mata</h1>
            <p class="text-gray-500">Klik setiap kartu untuk melihat penjelasan medis lebih lengkap</p>
        </div>

        <!-- IMAGE -->
        <div class="relative rounded-3xl overflow-hidden shadow-xl h-[500px]">
    <img src="{{ asset('images/gejala.jpg') }}"
         class="w-full h-full object-cover">

    
</div>
        <!-- INTRO -->
        <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
            <p class="text-gray-700 leading-relaxed">
                Gejala mata merupakan manifestasi klinis dari gangguan pada struktur atau fungsi organ penglihatan.
                Gejala ini dapat berkaitan dengan infeksi, kelainan refraksi, gangguan saraf, hingga penyakit degeneratif.
                Deteksi dini sangat penting untuk mencegah penurunan fungsi penglihatan permanen.
            </p>
        </div>

        <!-- GRID -->
        <div class="grid md:grid-cols-2 gap-6">

            <!-- 1 -->
            <div onclick="toggleDetail('g1')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-red-600">🔴 Hiperemia Konjungtiva</h2>
                <p class="text-gray-600 mt-2">Kemerahan pada bagian putih mata...</p>
                <div id="g1" class="hidden mt-4 text-gray-700 border-t pt-3 space-y-2">
                    <p>
                        Hiperemia konjungtiva adalah kondisi dilatasi atau pelebaran pembuluh darah pada konjungtiva,
                        yaitu membran tipis yang melapisi bagian putih mata dan kelopak mata bagian dalam.
                    </p>
                    <p>
                        Kondisi ini menyebabkan mata tampak merah secara menyeluruh atau lokal, dan sering disertai
                        rasa tidak nyaman seperti perih atau sensasi panas ringan.
                    </p>
                    <p><b>Penyebab utama:</b></p>
                    <ul class="list-disc pl-5">
                        <li>Iritasi lingkungan seperti debu, asap, dan polusi udara</li>
                        <li>Infeksi virus (conjunctivitis viral) atau bakteri</li>
                        <li>Reaksi alergi terhadap debu, serbuk sari, atau kosmetik</li>
                        <li>Kelelahan mata akibat penggunaan layar berlebihan</li>
                    </ul>
                </div>
            </div>

            <!-- 2 -->
            <div onclick="toggleDetail('g2')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-blue-600">👁️ Penurunan Visus</h2>
                <p class="text-gray-600 mt-2">Menurunnya ketajaman penglihatan...</p>
                <div id="g2" class="hidden mt-4 text-gray-700 border-t pt-3 space-y-2">
                    <p>
                        Penurunan visus merupakan kondisi ketika kemampuan mata dalam menangkap dan memfokuskan
                        objek mengalami penurunan, sehingga objek terlihat buram atau tidak jelas.
                    </p>
                    <p>
                        Kondisi ini dapat terjadi secara bertahap maupun mendadak tergantung penyebab yang mendasari.
                    </p>
                    <p><b>Penyebab umum:</b></p>
                    <ul class="list-disc pl-5">
                        <li>Kelainan refraksi (miopia, hipermetropi, astigmatisma)</li>
                        <li>Katarak yang menyebabkan lensa mata menjadi keruh</li>
                        <li>Gangguan retina atau saraf optik</li>
                        <li>Komplikasi penyakit sistemik seperti diabetes (retinopati diabetik)</li>
                    </ul>
                </div>
            </div>

            <!-- 3 -->
            <div onclick="toggleDetail('g3')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-yellow-600">🌞 Fotofobia</h2>
                <p class="text-gray-600 mt-2">Sensitivitas cahaya berlebihan...</p>
                <div id="g3" class="hidden mt-4 text-gray-700 border-t pt-3 space-y-2">
                    <p>
                        Fotofobia adalah kondisi meningkatnya sensitivitas mata terhadap cahaya,
                        yang menyebabkan ketidaknyamanan hingga rasa nyeri saat terpapar cahaya terang.
                    </p>
                    <p>
                        Kondisi ini bukan penyakit utama, melainkan gejala dari gangguan lain pada mata atau sistem saraf.
                    </p>
                    <p><b>Penyebab:</b></p>
                    <ul class="list-disc pl-5">
                        <li>Infeksi kornea (keratitis)</li>
                        <li>Uveitis atau peradangan bagian dalam mata</li>
                        <li>Migrain atau gangguan neurologis</li>
                        <li>Mata kering kronis</li>
                    </ul>
                </div>
            </div>

            <!-- 4 -->
            <div onclick="toggleDetail('g4')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-purple-600">🧬 Indikasi Selaput</h2>
                <p class="text-gray-600 mt-2">Pertumbuhan jaringan atau kekeruhan...</p>
                <div id="g4" class="hidden mt-4 text-gray-700 border-t pt-3 space-y-2">
                    <p>
                        Indikasi selaput menggambarkan adanya pertumbuhan jaringan abnormal atau kekeruhan pada
                        struktur optik mata yang dapat mengganggu jalur masuk cahaya.
                    </p>
                    <p><b>Kondisi terkait:</b></p>
                    <ul class="list-disc pl-5">
                        <li>Pterygium: pertumbuhan jaringan pada konjungtiva yang dapat menutupi kornea</li>
                        <li>Katarak: kekeruhan pada lensa mata yang menghambat cahaya masuk</li>
                    </ul>
                </div>
            </div>

            <!-- 5 -->
            <div onclick="toggleDetail('g5')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-green-600">💧 Mata Berair</h2>
                <p class="text-gray-600 mt-2">Produksi air mata berlebihan...</p>
                <div id="g5" class="hidden mt-4 text-gray-700 border-t pt-3 space-y-2">
                    <p>
                        Mata berair atau epiphora adalah kondisi produksi air mata yang berlebihan atau tidak
                        dapat dialirkan dengan normal melalui saluran lakrimal.
                    </p>
                    <p><b>Penyebab:</b></p>
                    <ul class="list-disc pl-5">
                        <li>Iritasi akibat debu, asap, atau benda asing</li>
                        <li>Alergi mata</li>
                        <li>Sumbatan saluran air mata</li>
                        <li>Infeksi pada sistem lakrimal</li>
                    </ul>
                </div>
            </div>

            <!-- 6 -->
            <div onclick="toggleDetail('g6')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-pink-600">🔥 Mata Gatal</h2>
                <p class="text-gray-600 mt-2">Sensasi ingin menggaruk mata...</p>
                <div id="g6" class="hidden mt-4 text-gray-700 border-t pt-3 space-y-2">
                    <p>
                        Mata gatal merupakan sensasi tidak nyaman pada permukaan mata yang sering
                        memicu keinginan untuk menggosok atau menggaruk mata.
                    </p>
                    <p><b>Penyebab:</b></p>
                    <ul class="list-disc pl-5">
                        <li>Reaksi alergi (serbuk sari, debu, bulu hewan)</li>
                        <li>Infeksi ringan pada konjungtiva</li>
                        <li>Mata kering</li>
                        <li>Iritasi akibat penggunaan lensa kontak</li>
                    </ul>
                </div>
            </div>

            <!-- 7 -->
            <div onclick="toggleDetail('g7')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-indigo-600">👀 Mata Lelah</h2>
                <p class="text-gray-600 mt-2">Kelelahan visual akibat aktivitas...</p>
                <div id="g7" class="hidden mt-4 text-gray-700 border-t pt-3 space-y-2">
                    <p>
                        Mata lelah atau asthenopia adalah kondisi kelelahan otot mata akibat penggunaan
                        visual yang berlebihan dalam jangka waktu lama.
                    </p>
                    <p><b>Penyebab:</b></p>
                    <ul class="list-disc pl-5">
                        <li>Menatap layar gadget terlalu lama</li>
                        <li>Pencahayaan yang tidak sesuai</li>
                        <li>Kurang istirahat mata</li>
                        <li>Gangguan refraksi yang tidak dikoreksi</li>
                    </ul>
                </div>
            </div>

            <!-- 8 -->
            <div onclick="toggleDetail('g8')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-orange-600">🌫️ Penglihatan Berkabut</h2>
                <p class="text-gray-600 mt-2">Pandangan seperti tertutup kabut...</p>
                <div id="g8" class="hidden mt-4 text-gray-700 border-t pt-3 space-y-2">
                    <p>
                        Penglihatan berkabut adalah kondisi di mana objek terlihat tidak jelas,
                        seolah tertutup lapisan kabut atau film tipis.
                    </p>
                    <p><b>Penyebab:</b></p>
                    <ul class="list-disc pl-5">
                        <li>Katarak stadium awal</li>
                        <li>Mata kering kronis</li>
                        <li>Gangguan refraksi yang tidak dikoreksi</li>
                        <li>Edema kornea</li>
                    </ul>
                </div>
            </div>

            <!-- 9 -->
            <div onclick="toggleDetail('g9')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-cyan-600">👁️ Mata Kering</h2>
                <p class="text-gray-600 mt-2">Kurangnya pelumasan mata...</p>
                <div id="g9" class="hidden mt-4 text-gray-700 border-t pt-3 space-y-2">
                    <p>
                        Mata kering adalah kondisi ketika produksi air mata tidak cukup
                        untuk menjaga kelembapan permukaan mata.
                    </p>
                    <p><b>Penyebab:</b></p>
                    <ul class="list-disc pl-5">
                        <li>Penggunaan komputer terlalu lama</li>
                        <li>Usia lanjut</li>
                        <li>Lingkungan kering atau AC</li>
                    </ul>
                </div>
            </div>

            <!-- 10 -->
            <div onclick="toggleDetail('g10')" class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold text-emerald-600">⚡ Penglihatan Ganda</h2>
                <p class="text-gray-600 mt-2">Melihat satu objek menjadi dua...</p>
                <div id="g10" class="hidden mt-4 text-gray-700 border-t pt-3 space-y-2">
                    <p>
                        Penglihatan ganda (diplopia) adalah kondisi ketika seseorang melihat dua bayangan
                        dari satu objek yang sama.
                    </p>
                    <p><b>Penyebab:</b></p>
                    <ul class="list-disc pl-5">
                        <li>Gangguan otot mata</li>
                        <li>Kelainan saraf kranial</li>
                        <li>Trauma kepala atau mata</li>
                    </ul>
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