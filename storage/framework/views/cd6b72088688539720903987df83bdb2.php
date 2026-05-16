<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EyeExpert - Cek Kesehatan Mata Praktis dengan AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');
        
        /* Perbaikan: Agar landing tepat di bawah navbar saat diklik */
        html {
            scroll-padding-top: 90px;
        }
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 p-4 lg:p-5 px-6 lg:px-20 flex justify-between items-center glass border-b border-white/20">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-lg shadow-blue-200">
                <i class="fa-solid fa-eye text-xl"></i>
            </div>
            <span class="text-2xl font-extrabold tracking-tight text-blue-900">Eye<span class="text-blue-600">Expert.</span></span>
        </div>

        <!-- Menu Tengah -->
        <div class="hidden md:flex gap-8 font-semibold text-slate-600" id="nav-menu">
            <a href="#about" class="nav-link hover:text-blue-600 transition duration-300">Cara Kerja</a>
            <a href="#edukasi" class="nav-link hover:text-blue-600 transition duration-300">Info Penyakit</a>
        </div>

        <!-- Tombol Auth -->
        <div class="flex items-center gap-4">
            <?php if(Route::has('login')): ?>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>" class="bg-blue-600 text-white px-7 py-2.5 rounded-full font-bold hover:bg-blue-700 shadow-lg transition">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-slate-600 font-bold mr-2 hidden sm:inline-block">Masuk</a>
                    <a href="<?php echo e(route('register')); ?>" class="bg-slate-900 text-white px-7 py-2.5 rounded-full font-bold hover:bg-slate-800 transition shadow-lg">Daftar</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="container mx-auto px-6 lg:px-20 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2 text-center lg:text-left">
                    <span class="bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest border border-blue-200">Medical Computation Engine</span>
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 mt-6 leading-tight">
                        Masa Depan <br> <span class="text-blue-600">Kesehatan Mata</span>
                    </h1>
                    <p class="text-lg text-slate-600 mt-6 mb-10 leading-relaxed max-w-xl">
                        EyeExpert menggunakan algoritma <strong>Deep Learning</strong> canggih untuk membantu Anda mendeteksi indikasi dini penyakit mata hanya melalui sebuah foto.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="<?php echo e(route('diagnosa.index')); ?>" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 shadow-2xl shadow-blue-300 transition transform hover:-translate-y-1">
                            Mulai Pemeriksaan Mandiri <i class="fa-solid fa-microscope ml-2"></i>
                        </a>
                    </div>
                </div>
                <div class="lg:w-1/2 relative">
                    <div class="absolute -z-10 w-72 h-72 bg-blue-400 rounded-full blur-[100px] opacity-20 top-0 left-0"></div>
                    <div class="relative p-4 bg-white rounded-[2rem] shadow-2xl border border-slate-100">
                        <img src="https://images.unsplash.com/photo-1551601651-2a8555f1a136?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Eye Health" class="rounded-[1.5rem] w-full object-cover h-[300px] lg:h-full">
                        <div class="absolute -bottom-6 -left-6 glass p-5 rounded-2xl shadow-xl border border-white">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse shadow-sm shadow-green-400"></div>
                                <span class="font-bold text-slate-700 text-sm italic tracking-tight uppercase">Ocular Scanner Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Konten Cara Kerja (About) -->
<section id="about" class="py-20 lg:py-24 bg-slate-900 text-white relative overflow-hidden">
    <!-- Dekorasi Latar Belakang -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px]"></div>
    
    <div class="container mx-auto px-6 lg:px-20 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl lg:text-4xl font-extrabold tracking-tight text-white mb-4">Bagaimana Sistem Bekerja?</h2>
            <p class="text-slate-400 text-sm lg:text-base">Proses analisis medis kami menggunakan standar protokol sistem pakar yang terintegrasi dengan kecerdasan buatan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Langkah 1 -->
            <div class="relative text-center group">
                <div class="w-20 h-20 mx-auto bg-slate-800 rounded-3xl flex items-center justify-center mb-6 border border-slate-700 group-hover:border-blue-500 transition-all duration-300">
                    <i class="fa-solid fa-clipboard-list text-3xl text-blue-400"></i>
                    <span class="absolute -top-2 -right-2 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-sm font-bold border-4 border-slate-900">1</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-white">Anamnesa Digital</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Sistem mengumpulkan data awal berupa usia dan manifestasi klinis (gejala) yang Anda alami melalui form interaktif.</p>
            </div>

            <!-- Langkah 2 -->
            <div class="relative text-center group">
                <div class="w-20 h-20 mx-auto bg-slate-800 rounded-3xl flex items-center justify-center mb-6 border border-slate-700 group-hover:border-blue-500 transition-all duration-300">
                    <i class="fa-solid fa-camera-retro text-3xl text-blue-400"></i>
                    <span class="absolute -top-2 -right-2 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-sm font-bold border-4 border-slate-900">2</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-white">Akuisisi Citra</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Pengunggahan foto kondisi mata secara *real-time*. Citra ini akan diproses untuk mengekstraksi fitur-fitur patologis yang tidak tertangkap mata telanjang.</p>
            </div>

            <!-- Langkah 3 -->
            <div class="relative text-center group">
                <div class="w-20 h-20 mx-auto bg-slate-800 rounded-3xl flex items-center justify-center mb-6 border border-slate-700 group-hover:border-blue-500 transition-all duration-300">
                    <i class="fa-solid fa-brain text-3xl text-blue-400"></i>
                    <span class="absolute -top-2 -right-2 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-sm font-bold border-4 border-slate-900">3</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-white">Analisis Komputasi</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Algoritma kami mencocokkan data Anda dengan ribuan dataset medis untuk memberikan indikasi diagnosa awal yang akurat dalam hitungan detik.</p>
            </div>
        </div>

        <!-- Statistik Kecil di Bawah Langkah-langkah -->
        <div class="mt-20 pt-10 border-t border-slate-800 grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
            <div>
                <p class="text-2xl font-bold text-blue-400">95%</p>
                <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold">Akurasi AI</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-blue-400">Secure</p>
                <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold">Privasi Data</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-blue-400">3000+</p>
                <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold">Dataset</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-blue-400">&lt; 5s</p>
                <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold">Analisis</p>
            </div>
        </div>
    </div>
</section>

    <!-- Education Section -->
   <section id="edukasi" class="py-20 lg:py-24 bg-white">
    <div class="container mx-auto px-6 lg:px-20">
        <div class="text-center max-w-2xl mx-auto mb-16 lg:mb-20">
            <span class="text-blue-600 font-bold text-sm uppercase tracking-widest">Ensiklopedia Medis</span>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight mt-2">Patologi Mata Umum</h2>
            <p class="text-slate-600 mt-4 italic text-base lg:text-lg italic leading-relaxed">"Informasi ini bertujuan untuk edukasi dini, bukan pengganti konsultasi medis profesional."</p>
        </div>

            <!-- Perbaikan: Grid Responsive -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                <!-- Katarak -->
                <div class="group p-8 lg:p-10 bg-white rounded-[2rem] lg:rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-600 transition-colors duration-500">
                        <i class="fa-solid fa-circle-notch text-3xl text-blue-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-4 text-slate-800 tracking-tight">Katarak</h3>
                    <p class="text-slate-600 leading-relaxed text-sm text-justify">Pengentalan atau kekeruhan pada lensa mata yang menghalangi cahaya masuk. Umumnya berkembang seiring bertambahnya usia.</p>
                </div>

                <!-- Glaukoma -->
                <div class="group p-8 lg:p-10 bg-white rounded-[2rem] lg:rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-red-100 transition-all duration-500 hover:-translate-y-2 border-b-4 border-b-transparent hover:border-b-red-500">
                    <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-red-500 transition-colors duration-500">
                        <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-4 text-slate-800 tracking-tight">Glaukoma</h3>
                    <p class="text-slate-600 leading-relaxed text-sm text-justify">Dikenal sebagai "Si Pencuri Penglihatan". Kerusakan saraf optik akibat tekanan cairan bola mata yang terlalu tinggi.</p>
                </div>

                <!-- Mata Sehat -->
                <div class="group p-8 lg:p-10 bg-white rounded-[2rem] lg:rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-green-100 transition-all duration-500 hover:-translate-y-2 border-b-4 border-b-transparent hover:border-b-green-500">
                    <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-green-500 transition-colors duration-500">
                        <i class="fa-solid fa-shield-halved text-3xl text-green-500 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-4 text-slate-800 tracking-tight">Mata Sehat</h3>
                    <p class="text-slate-600 leading-relaxed text-sm text-justify">Fungsi mata yang optimal dengan lensa jernih dan tekanan normal. Pastikan nutrisi sayuran hijau untuk menjaga retina.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-12">
        <div class="container mx-auto px-6 text-center">
            <p class="font-bold text-slate-400 uppercase tracking-[0.2em] text-[10px] mb-4">Proyek Praktik Sistem Pakar - 2026</p>
            <div class="flex justify-center gap-6 text-slate-300 text-xl mb-8">
                <i class="fa-brands fa-github hover:text-slate-900 cursor-pointer"></i>
                <i class="fa-brands fa-laravel hover:text-red-500 cursor-pointer"></i>
                <i class="fa-brands fa-python hover:text-blue-500 cursor-pointer"></i>
            </div>
            <p class="text-slate-500 text-xs">© 2026 <strong>Indrawan Ophthalmology Project</strong>. Dirancang untuk edukasi dan bantuan medis berbasis komputasi.</p>
        </div>
    </footer>

    <script>
        // Ambil elemen
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-link');

        // Fungsi klik: Ubah warna secara manual saat diklik
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(innerLink => {
                    innerLink.classList.replace('text-blue-600', 'text-slate-600');
                });
                this.classList.replace('text-slate-600', 'text-blue-600');
            });
        });

        // Perbaikan: Auto-Update warna menu saat scroll
        window.addEventListener('scroll', () => {
            let current = "";
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= (sectionTop - 150)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('text-blue-600');
                link.classList.add('text-slate-600');
                if (link.getAttribute('href').includes(current)) {
                    link.classList.remove('text-slate-600');
                    link.classList.add('text-blue-600');
                }
            });
        });
    </script>
</body>
</html><?php /**PATH D:\XampUtama\htdocs\prediksi_kondisi_mata\resources\views/landing.blade.php ENDPATH**/ ?>