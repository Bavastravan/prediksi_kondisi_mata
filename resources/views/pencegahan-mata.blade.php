<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-emerald-50/60 via-white to-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 sm:py-16">

            {{-- HERO / HEADER --}}
            <header class="text-center space-y-4 mb-10">
                
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-gray-900 text-balance">
                    Pencegahan Penyakit Mata
                </h1>
                <p class="max-w-2xl mx-auto text-gray-500 leading-relaxed text-pretty">
                    Banyak gangguan penglihatan dapat dicegah sejak dini melalui kebiasaan
                    sehari-hari yang benar. Ketuk setiap kartu untuk membaca penjelasan lengkapnya.
                </p>
            </header>

            {{-- IMAGE --}}
            <div class="relative overflow-hidden rounded-3xl shadow-xl ring-1 ring-black/5 mb-8">
                <img src="{{ asset('images/pencegahan.jpg') }}"
                     alt="Pemeriksaan dan perawatan kesehatan mata"
                     class="w-full object-cover max-h-[420px]">
                <div class="absolute inset-0 bg-gradient-to-t from-black/25 to-transparent"></div>
            </div>

            {{-- INTRO --}}
            <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-6 mb-10">
                <p class="text-gray-700 leading-relaxed">
                    Pencegahan penyakit mata merupakan bagian penting dari kesehatan umum manusia.
                    Banyak gangguan penglihatan dapat dicegah sejak dini melalui kebiasaan sehari-hari yang benar,
                    pola hidup sehat, serta perlindungan mata dari faktor lingkungan yang berbahaya.
                </p>
            </div>

            {{-- GRID --}}
            @php
                $tips = [
                    ['Nutrisi Seimbang', 'Asupan gizi yang tepat menjaga fungsi retina dan melindungi sel mata.', 'Nutrisi memiliki peran penting dalam menjaga kesehatan mata. Vitamin A membantu pembentukan pigmen retina yang berfungsi dalam penglihatan malam, sementara vitamin C dan E berperan sebagai antioksidan yang melindungi sel mata dari kerusakan akibat radikal bebas. Lutein dan zeaxanthin membantu melindungi retina dari cahaya biru berlebih. Kekurangan nutrisi ini dapat meningkatkan risiko gangguan seperti degenerasi makula dan rabun senja.'],
                    ['Atur Penggunaan Gadget', 'Kurangi kelelahan mata digital dengan pola pemakaian layar yang sehat.', 'Penggunaan gadget yang berlebihan dapat menyebabkan digital eye strain atau kelelahan mata digital. Gejalanya meliputi mata kering, penglihatan kabur, dan sakit kepala. Aturan 20-20-20 sangat dianjurkan: setiap 20 menit melihat layar, alihkan pandangan ke objek sejauh 20 kaki selama 20 detik. Selain itu, atur kecerahan layar agar tidak terlalu tinggi dan gunakan mode malam untuk mengurangi paparan cahaya biru.'],
                    ['Kebersihan Mata', 'Cegah infeksi dengan menjaga kebersihan tangan dan area mata.', 'Kebersihan mata sangat penting untuk mencegah infeksi seperti konjungtivitis. Tangan adalah sumber utama bakteri dan virus, sehingga tidak boleh menyentuh mata sebelum mencuci tangan. Penggunaan handuk, kosmetik mata, dan lensa kontak secara bergantian dengan orang lain sangat tidak dianjurkan karena dapat menularkan penyakit. Membersihkan area mata secara rutin juga membantu menjaga kesehatan kelopak dan bulu mata.'],
                    ['Pemeriksaan Rutin', 'Deteksi dini menyelamatkan penglihatan sebelum gejala muncul.', 'Pemeriksaan mata secara rutin sangat penting meskipun tidak ada keluhan. Banyak penyakit mata seperti glaukoma berkembang tanpa gejala awal yang jelas. Dengan pemeriksaan berkala, dokter dapat mendeteksi perubahan tekanan mata, kondisi retina, dan refraksi sejak dini. Hal ini sangat membantu dalam mencegah kerusakan penglihatan permanen yang sulit diperbaiki.'],
                    ['Perlindungan dari Sinar UV', 'Lindungi lensa mata dari kerusakan akibat sinar matahari.', 'Paparan sinar ultraviolet dalam jangka panjang dapat mempercepat kerusakan lensa mata dan meningkatkan risiko katarak serta pterygium. Oleh karena itu, penggunaan kacamata hitam dengan perlindungan UV400 sangat dianjurkan saat berada di luar ruangan. Perlindungan ini sangat penting terutama bagi orang yang sering bekerja di bawah sinar matahari langsung.'],
                    ['Menjaga Kelembapan Mata', 'Hindari mata kering dengan menjaga kelembapan yang cukup.', 'Mata membutuhkan kelembapan yang cukup agar dapat berfungsi dengan baik. Kondisi lingkungan seperti AC, angin kencang, atau layar komputer dapat menyebabkan mata menjadi kering. Penggunaan tetes mata (artificial tears) dapat membantu menjaga kelembapan dan mengurangi rasa perih atau seperti berpasir pada mata.'],
                    ['Ergonomi & Jarak Layar', 'Posisi kerja yang benar mengurangi ketegangan pada mata.', 'Posisi tubuh dan jarak layar sangat mempengaruhi kesehatan mata. Jarak ideal antara mata dan layar komputer adalah sekitar 50-70 cm dengan posisi layar sedikit di bawah garis pandang. Posisi yang tidak ergonomis dapat menyebabkan kelelahan mata, sakit kepala, dan nyeri leher.'],
                    ['Hindari Asap & Polusi', 'Lindungi mata dari iritasi zat berbahaya di udara.', 'Asap rokok dan polusi udara mengandung zat berbahaya yang dapat mengiritasi mata. Paparan jangka panjang dapat memperburuk kondisi mata kering dan meningkatkan risiko peradangan. Menggunakan pelindung mata atau menghindari lingkungan berpolusi dapat membantu menjaga kesehatan mata.'],
                    ['Istirahat yang Cukup', 'Tidur berkualitas membantu mata pulih dan beregenerasi.', 'Tidur yang cukup sangat penting untuk pemulihan mata setelah aktivitas sehari-hari. Kurang tidur dapat menyebabkan mata merah, bengkak, dan sulit fokus. Saat tidur, mata melakukan regenerasi sel dan pemulihan fungsi visual agar tetap optimal keesokan harinya.'],
                    ['Hindari Mengucek Mata', 'Mengucek mata berisiko merusak kornea dan menyebarkan kuman.', 'Mengucek mata dapat menyebabkan kerusakan pada kornea, meningkatkan risiko infeksi, dan memperburuk kondisi iritasi. Jika mata terasa gatal atau tidak nyaman, lebih baik menggunakan obat tetes mata steril atau berkonsultasi dengan dokter.'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">
                @foreach ($tips as $i => $tip)
                    <div x-data="{ open: false }"
                         class="group self-start rounded-2xl bg-white ring-1 ring-gray-100 shadow-sm transition-all duration-300 hover:shadow-md hover:ring-emerald-200">
                        <button type="button"
                                @click="open = !open"
                                :aria-expanded="open"
                                class="w-full flex items-start gap-4 p-5 text-left rounded-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-sm font-semibold text-emerald-700 transition-colors group-hover:bg-emerald-600 group-hover:text-white">
                                {{ sprintf('%02d', $i + 1) }}
                            </span>
                            <span class="flex-1">
                                <span class="block font-semibold text-gray-800">{{ $tip[0] }}</span>
                                <span class="block text-sm text-gray-500 mt-1 leading-relaxed">{{ $tip[1] }}</span>
                            </span>
                            <svg class="h-5 w-5 shrink-0 text-gray-400 transition-transform duration-300 mt-1"
                                 :class="{ 'rotate-180 text-emerald-600': open }"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-collapse style="display:none">
                            <p class="px-5 pb-5 text-gray-600 leading-relaxed border-t border-gray-100 pt-4">
                                {{ $tip[2] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- FOOTER NOTE --}}
            <div class="mt-12 rounded-2xl bg-gray-900 text-center p-6 sm:p-8">
                <p class="text-gray-200 leading-relaxed text-pretty max-w-2xl mx-auto">
                    Menjaga kesehatan mata adalah investasi jangka panjang. Terapkan kebiasaan baik
                    sejak dini dan jangan ragu berkonsultasi dengan tenaga medis bila mengalami keluhan.
                </p>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 pt-6 pb-12 text-center relative">
        <div class="container mx-auto px-6 text-center">
                       <p class="text-slate-500 text-xs">© 2026 <strong>Sistem Pakar Pendeteksi Gangguan Mata</strong>. Dirancang untuk edukasi dan bantuan medis berbasis komputasi.</p>
        </div>
    </footer>
    
    {{-- Fallback bila Alpine.js tidak tersedia --}}
    <script>
        if (typeof window.Alpine === 'undefined') {
            document.querySelectorAll('[x-data]').forEach(function (card) {
                var btn = card.querySelector('button');
                var panel = card.querySelector('[x-show]');
                var icon = card.querySelector('svg.transition-transform');
                if (!btn || !panel) return;
                panel.style.display = 'none';
                btn.addEventListener('click', function () {
                    var isOpen = panel.style.display !== 'none';
                    panel.style.display = isOpen ? 'none' : 'block';
                    if (icon) icon.classList.toggle('rotate-180', !isOpen);
                    if (icon) icon.classList.toggle('text-emerald-600', !isOpen);
                });
            });
        }
    </script>
</x-app-layout>