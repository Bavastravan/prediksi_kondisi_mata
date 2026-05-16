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
    @if (Route::has('login'))
        @auth
            <div class="relative inline-block text-left">
                
                <button type="button" id="dropdownUserButton" class="flex items-center gap-3 bg-white border border-slate-200/80 hover:border-blue-300 px-5 py-2 rounded-full shadow-sm hover:shadow-md transition duration-300 group focus:outline-none">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                        <i class="fa-solid fa-user-circle text-lg"></i>
                    </div>
                    
                    <span class="flex items-center gap-2 font-bold text-slate-700 group-hover:text-blue-600 text-sm transition duration-300">
                        {{ Auth::user()->name }}
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-blue-500 transition duration-300"></i>
                    </span>
                </button>

                <div id="dropdownUserMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 transform origin-top-right transition duration-200">
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition">
                        <i class="fa-solid fa-user-gear w-4 text-center"></i> Profile
                    </a>

                    <hr class="border-slate-100 my-1">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition text-left">
                            <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Log Out
                        </button>
                    </form>
                </div>

            </div>
        @else
            <a href="{{ route('login') }}" class="text-slate-600 font-bold mr-2 hidden sm:inline-block hover:text-blue-600 transition">Masuk</a>
            <a href="{{ route('register') }}" class="bg-slate-900 text-white px-7 py-2.5 rounded-full font-bold hover:bg-slate-800 transition shadow-lg">Daftar</a>
        @endauth
    @endif
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
                       <a href="{{ url('/gejala-mata') }}" class="inline-block bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 shadow-2xl shadow-blue-300 transition transform hover:-translate-y-1">
    Pelajari Tentang Mata <i class="fa-solid fa-eye ml-2"></i>
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

        // Logika Penggerak Dropdown Navbar
    const dropdownBtn = document.getElementById('dropdownUserButton');
    const dropdownMenu = document.getElementById('dropdownUserMenu');

    if (dropdownBtn && dropdownMenu) {
        // 1. Aksi ketika tombol nama di-klik
        dropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Mencegah event klik tembus ke luar
            dropdownMenu.classList.toggle('hidden');
        });

        // 2. Tutup dropdown otomatis jika user mengklik area lain di luar menu
        window.addEventListener('click', (e) => {
            if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    }

    // Logika Buka Tutup Pop-up Modal Diagnosa
const openBtn = document.getElementById('openDiagnosaModal');
const closeBtn = document.getElementById('closeDiagnosaModal');
const modalBox = document.getElementById('diagnosaModal');

if (openBtn && modalBox) {
    openBtn.addEventListener('click', () => {
        modalBox.classList.remove('hidden');
    });
    
    closeBtn.addEventListener('click', () => {
        modalBox.classList.add('hidden');
    });

    // Tutup jika klik area hitam di luar kotak putih
    modalBox.addEventListener('click', (e) => {
        if (e.target === modalBox) {
            modalBox.classList.add('hidden');
        }
    });
}
    </script>

  <style>
    /* CSS Dasar Kontainer Mengambang */
    .floating-decor {
        position: fixed;
        bottom: 0; 
        z-index: 45; 
        display: flex;
        align-items: flex-end; 
        justify-content: center;
        transition: all 0.3s ease-out;
        pointer-events: none; 
    }

    /* --- PENGATURAN MIKROSKOP (KIRI) --- */
    .decor-left {
        left: 25px;
        bottom: 25px; 
        animation: float-microscope 4s ease-in-out infinite;
    }

    /* Bingkai Kaca Putih Transparan untuk Ikon Mata (PENGGANTI BIRU) */
    .decor-left .icon-glass {
        width: 85px;
        height: 85px;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.6) !important; /* Menggunakan putih transparan */
        border: 1px solid rgba(255, 255, 255, 0.8) !important; /* Garis tepi putih halus */
        backdrop-filter: blur(12px) !important;
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08) !important; /* Bayangan abu-abu lembut agar tidak kotor */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .decor-left i {
        font-size: 38px;
        color: #2563eb;
    }
/* --- PENGATURAN DOKTER (KANAN) --- */
.decor-right {
    right: -20px !important; /* Geser sedikit ke kanan */
    bottom: 0 !important;

    height: 48vh !important; /* Diperkecil sedikit */
    width: auto;

    animation: float-doctor 4.5s ease-in-out infinite;

    pointer-events: auto !important;

    opacity: 0.96;
}

.doctor-standing-img {
    height: 100% !important;
    width: auto !important;

    display: block;
    object-fit: contain;

    background: transparent !important;
    border: none !important;
    box-shadow: none !important;

    filter: drop-shadow(-10px 10px 25px rgba(15, 23, 42, 0.14));
}

/* Hover halus */
.decor-right:hover {
    transform: scale(1.02);
}

    /* KEYFRAMES ANIMASI MENGAMBANG ALAMI */
    @keyframes float-microscope {
        0% { transform: translateY(0px) rotate(-1deg); }
        50% { transform: translateY(-10px) rotate(1deg); }
        100% { transform: translateY(0px) rotate(-1deg); }
    }

    @keyframes float-doctor {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-12px); } /* Gerakan naik turun vertikal yang lebih anggun */
        100% { transform: translateY(0px); }
    }

    /* ================================================= */
    /* RESPONSIVE RESPONSIVITAS MOBILE (HP) */
    /* ================================================= */
   @media (max-width: 768px) {
       .decor-left .icon-glass {
            width: 65px;
            height: 65px;
            background: rgba(255, 255, 255, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.8) !important;
        }

        .decor-left i {
            font-size: 28px;
        }

        .decor-left {
            left: 12px;
            bottom: 15px;
        }

        /* Di HP tingginya kita buat 30% dari layar agar tidak menutupi fungsionalitas tombol utama */
        .decor-right {
        right: -10px !important;
        height: 28vh !important;
        opacity: 0.92;
    }
    }

    /* ================================================= */
/* AI CHAT BUBBLE */
/* ================================================= */

.doctor-chat-bubble {
    position: absolute;

    top: 18%;
    left: -230px;

    max-width: 240px;

    background: rgba(255,255,255,0.92);

    backdrop-filter: blur(12px);

    padding: 16px 18px;

    border-radius: 24px;

    border: 1px solid rgba(255,255,255,0.8);

    box-shadow:
        0 15px 35px rgba(15,23,42,0.10);

    font-size: 15px;
    font-weight: 600;

    color: #1e293b;

    line-height: 1.5;

    animation: bubbleFloat 4s ease-in-out infinite;
}

/* Ekor Bubble */
.doctor-chat-bubble::after {
    content: "";

    position: absolute;

    right: -10px;
    top: 35px;

    width: 20px;
    height: 20px;

    background: rgba(255,255,255,0.92);

    transform: rotate(45deg);

    border-right: 1px solid rgba(255,255,255,0.8);
    border-top: 1px solid rgba(255,255,255,0.8);
}

/* Emoji tangan */
.wave-hand {
    font-size: 18px;
    margin-right: 6px;

    display: inline-block;

    animation: waving 2s infinite;
}

/* Animasi tangan */
@keyframes waving {
    0% { transform: rotate(0deg); }
    15% { transform: rotate(14deg); }
    30% { transform: rotate(-8deg); }
    45% { transform: rotate(14deg); }
    60% { transform: rotate(-4deg); }
    75% { transform: rotate(10deg); }
    100% { transform: rotate(0deg); }
}

/* Bubble floating */
@keyframes bubbleFloat {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-6px); }
    100% { transform: translateY(0px); }
}

/* ================================================= */
/* MOBILE RESPONSIVE */
/* ================================================= */

@media (max-width: 768px) {

    .doctor-chat-bubble {

        left: -170px;

        top: 10%;

        max-width: 170px;

        font-size: 11px;

        padding: 12px 14px;

        border-radius: 18px;
    }

    .doctor-chat-bubble::after {

        right: -8px;

        width: 16px;
        height: 16px;
    }
}
</style>

<a href="{{ route('diagnosa.index') }}" class="floating-decor decor-left group cursor-pointer" style="pointer-events: auto !important;">
    <div class="icon-glass">
        <img src="{{ asset('images/mata-icon.png') }}" 
             alt="Icon Mata EyeExpert" 
             class="w-16 h-16 md:w-20 md:h-20 object-contain transition duration-300 group-hover:scale-110">
    </div>
</a>
<div class="floating-decor decor-right">

    <!-- Bubble Chat AI -->
    <div class="doctor-chat-bubble">
        <span class="wave-hand">👋</span>
        Hai, ada apa dengan matamu 
        <strong>
            {{ Auth::check() ? Auth::user()->name : 'Teman' }}
        </strong>?
    </div>

    <img src="{{ asset('images/doctor-image2.png') }}" 
         alt="Dokter Ahli Oftalmologi EyeExpert" 
         class="doctor-standing-img">
</div>
    <img src="{{ asset('images/doctor-image2.png') }}" 
         alt="Dokter Ahli Oftalmologi EyeExpert" 
         class="doctor-standing-img">
</div>

</body>
</html>