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

        html { scroll-behavior: smooth; }

        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }

        #edukasi { scroll-margin-top: 5rem; }

        .nav-link { transition: color 0.3s ease; }
        .nav-link:hover { color: #2563eb; }

        /* ================================================= */
        /* MOBILE MENU HAMBURGER ANIMATION                   */
        /* ================================================= */

        /* Saat menu terbuka: bar atas & bawah jadi silang X */
        #mobileMenuBtn.is-open .hamburger-bar:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }
        #mobileMenuBtn.is-open .hamburger-bar:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }
        #mobileMenuBtn.is-open .hamburger-bar:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        /* ================================================= */
        /* DOKTER FLOATING — HIDE/SHOW SYSTEM                */
        /* ================================================= */

        /*
         * Wrapper posisi: fixed, kanan bawah.
         * Default: tersembunyi penuh di luar layar kanan.
         */
        .decor-right {
            position: fixed;
            right: 0;
            bottom: 0;
            z-index: 45;
            height: 48vh;
            width: auto;
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            pointer-events: auto;

            /* STATE DEFAULT: sembunyi penuh ke kanan */
            transform: translateX(100%);
            transition: transform 0.45s ease-in-out;
        }

        /* STATE AKTIF: muncul sepenuhnya (via JS class atau hover) */
        .decor-right.is-visible {
            transform: translateX(0%);
            animation: float-doctor 4.5s ease-in-out infinite;
            /* Nonaktifkan transition saat animasi float aktif agar tidak mental */
            transition: transform 0.45s ease-in-out;
        }

        /* Hover langsung via CSS sebagai fallback/tambahan */
        .decor-right:hover {
            transform: translateX(0%) !important;
            animation: float-doctor 4.5s ease-in-out infinite !important;
        }

        /* Gambar dokter */
        .doctor-standing-img {
            height: 100%;
            width: auto;
            display: block;
            object-fit: contain;
            background: transparent;
            border: none;
            box-shadow: none;
            filter: drop-shadow(-10px 10px 25px rgba(15, 23, 42, 0.14));
            /* Sedikit visible hint saat menepi */
            border-radius: 0;
        }

        /* ================================================= */
        /* CHAT BUBBLE                                        */
        /* ================================================= */

        .doctor-chat-bubble {
            position: absolute;
            top: 18%;
            left: -230px;
            max-width: 240px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            padding: 16px 18px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.10);
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.5;
            white-space: normal;

            /* Default: tersembunyi */
            opacity: 0;
            transform: translateX(16px);
            pointer-events: none;
            transition:
                opacity 0.35s ease 0.15s,
                transform 0.35s ease 0.15s;
        }

        /* Bubble muncul saat dokter visible */
        .decor-right.is-visible .doctor-chat-bubble,
        .decor-right:hover .doctor-chat-bubble {
            opacity: 1;
            transform: translateX(0px);
            pointer-events: auto;
        }

        /* Ekor bubble */
        .doctor-chat-bubble::after {
            content: "";
            position: absolute;
            right: -10px;
            top: 35px;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.92);
            transform: rotate(45deg);
            border-right: 1px solid rgba(255, 255, 255, 0.8);
            border-top: 1px solid rgba(255, 255, 255, 0.8);
        }

        /* Emoji tangan */
        .wave-hand {
            font-size: 18px;
            margin-right: 6px;
            display: inline-block;
            animation: waving 2s infinite;
        }

        /* ================================================= */
        /* HINT TAB — fixed di tepi kanan, selalu terlihat   */
        /* sebagai trigger untuk memunculkan dokter           */
        /* ================================================= */

        .doctor-hint-tab {
            position: fixed;
            right: 0;
            bottom: 38%;
            width: 32px;
            height: 76px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border-radius: 12px 0 0 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: -4px 0 16px rgba(37, 99, 235, 0.35);
            z-index: 46;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .doctor-hint-tab i {
            color: white;
            font-size: 15px;
        }

        /* Sembunyikan tab saat dokter sudah visible */
        .doctor-hint-tab.is-hidden {
            opacity: 0;
            pointer-events: none;
            transform: translateX(100%);
        }

        /* ================================================= */
        /* KEYFRAMES                                         */
        /* ================================================= */

        @keyframes float-doctor {
            0%   { transform: translateX(0%) translateY(0px); }
            50%  { transform: translateX(0%) translateY(-10px); }
            100% { transform: translateX(0%) translateY(0px); }
        }

        /* Saat animasi float aktif, nonaktifkan transition agar tidak konflik */
        .decor-right.is-visible,
        .decor-right:hover {
            transition: none !important;
        }

        @keyframes waving {
            0%   { transform: rotate(0deg); }
            15%  { transform: rotate(14deg); }
            30%  { transform: rotate(-8deg); }
            45%  { transform: rotate(14deg); }
            60%  { transform: rotate(-4deg); }
            75%  { transform: rotate(10deg); }
            100% { transform: rotate(0deg); }
        }

        @keyframes bubbleFloat {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-6px); }
            100% { transform: translateY(0px); }
        }

        /* ================================================= */
        /* DECORASI KIRI (TETAP)                             */
        /* ================================================= */

        .floating-decor {
            position: fixed;
            bottom: 0;
            z-index: 45;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            pointer-events: none;
        }

        .decor-left {
            left: 25px;
            bottom: 25px;
            animation: float-microscope 4s ease-in-out infinite;
        }

        .decor-left .icon-glass {
            width: 85px;
            height: 85px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .decor-left i { font-size: 38px; color: #2563eb; }

        @keyframes float-microscope {
            0%   { transform: translateY(0px) rotate(-1deg); }
            50%  { transform: translateY(-10px) rotate(1deg); }
            100% { transform: translateY(0px) rotate(-1deg); }
        }

        /* ================================================= */
        /* MOBILE RESPONSIVE                                 */
        /* ================================================= */

        @media (max-width: 768px) {

            /* Dokter lebih kecil & tersembunyi penuh di mobile */
            .decor-right {
                height: 30vh;
                transform: translateX(100%);
            }

            .decor-right.is-visible,
            .decor-right:hover {
                transform: translateX(0%) !important;
            }

            /* Bubble naik ke atas gambar dokter di mobile,
               agar tidak bertabrakan dengan FAB tooltip di kiri bawah */
            .doctor-chat-bubble {
                left: auto;
                right: 0;
                top: auto;
                bottom: 105%;    /* Posisi di atas gambar dokter */
                max-width: 160px;
                font-size: 11px;
                padding: 10px 13px;
                border-radius: 16px;
                transform: translateY(8px);
            }

            /* Override transition state di mobile */
            .decor-right.is-visible .doctor-chat-bubble,
            .decor-right:hover .doctor-chat-bubble {
                opacity: 1;
                transform: translateY(0px);
            }

            /* Ekor bubble mengarah ke bawah di mobile */
            .doctor-chat-bubble::after {
                right: 18px;
                top: auto;
                bottom: -10px;
                left: auto;
                width: 16px;
                height: 16px;
                border-right: none;
                border-top: none;
                border-left: 1px solid rgba(255,255,255,0.8);
                border-bottom: 1px solid rgba(255,255,255,0.8);
            }

            .doctor-hint-tab {
                width: 26px;
                height: 60px;
                border-radius: 10px 0 0 10px;
            }

            .doctor-hint-tab i { font-size: 12px; }

            .decor-left .icon-glass { width: 60px; height: 60px; }
            .decor-left i { font-size: 26px; }
            .decor-left { left: 12px; bottom: 15px; }
        }

        /* ================================================= */
        /* FAB BUTTON BOUNCE                                 */
        /* ================================================= */

        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-5px); }
        }
        .animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }

        /* ================================================= */
        /* FAB TOOLTIP SHOW/HIDE                             */
        /* ================================================= */

        /* State default tooltip: tersembunyi */
        .fab-tooltip-hidden {
            display: block !important; /* override hidden dari Tailwind */
            opacity: 0;
            transform: translateY(6px);
            pointer-events: none;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* State visible tooltip */
        .fab-tooltip-visible {
            opacity: 1;
            transform: translateY(0px);
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass border-b border-white/20" id="mainNav">
        <div class="mx-auto px-5 lg:px-20 flex items-center justify-between h-16 lg:h-18">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 shrink-0">
                <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-md shadow-blue-200">
                    <i class="fa-solid fa-eye text-base"></i>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-blue-900">Eye<span class="text-blue-600">Expert.</span></span>
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex items-center gap-8 font-semibold text-slate-600" id="nav-menu">
                <a href="#about" class="nav-link hover:text-blue-600 transition duration-300">Cara Kerja</a>
                <a href="{{ request()->is('/') ? '#fitur' : url('/#fitur') }}" class="nav-link hover:text-blue-600 transition duration-300">Fitur Sistem</a>
            </div>

            {{-- Auth + Hamburger --}}
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        {{-- User Dropdown --}}
                        <div class="relative">
                            <button type="button" id="dropdownUserButton"
                                    class="flex items-center gap-2 bg-white border border-slate-200/80 hover:border-blue-300 px-3 py-1.5 rounded-full shadow-sm hover:shadow-md transition duration-300 group focus:outline-none">
                                <div class="w-7 h-7 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                                    <i class="fa-solid fa-user text-xs"></i>
                                </div>
                                <span class="hidden sm:flex items-center gap-1.5 font-bold text-slate-700 group-hover:text-blue-600 text-sm transition duration-300 max-w-[120px] truncate">
                                    {{ Auth::user()->name }}
                                    <i class="fa-solid fa-chevron-down text-[9px] text-slate-400 group-hover:text-blue-500 transition duration-300 shrink-0"></i>
                                </span>
                                {{-- Hanya ikon di mobile --}}
                                <i class="sm:hidden fa-solid fa-chevron-down text-[9px] text-slate-400 group-hover:text-blue-500 transition duration-300"></i>
                            </button>

                            <div id="dropdownUserMenu"
                                 class="hidden absolute right-0 mt-2 w-44 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 origin-top-right">
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition rounded-xl mx-1">
                                    <i class="fa-solid fa-user-gear w-4 text-center"></i> Profile
                                </a>
                                <hr class="border-slate-100 my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-red-500 hover:bg-red-50 transition text-left rounded-xl mx-1" style="width: calc(100% - 8px)">
                                        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="hidden sm:inline-block text-slate-600 font-bold text-sm hover:text-blue-600 transition">Masuk</a>
                        <a href="{{ route('register') }}"
                           class="bg-slate-900 text-white px-5 py-2 rounded-full font-bold text-sm hover:bg-blue-700 transition shadow-md">Daftar</a>
                    @endauth
                @endif

                {{-- Hamburger (mobile only) --}}
                <button id="mobileMenuBtn"
                        class="md:hidden flex flex-col justify-center items-center w-9 h-9 rounded-lg border border-slate-200 bg-white/80 gap-1.5 hover:border-blue-300 transition"
                        aria-label="Buka menu">
                    <span class="hamburger-bar block w-5 h-0.5 bg-slate-700 rounded transition-all duration-300"></span>
                    <span class="hamburger-bar block w-5 h-0.5 bg-slate-700 rounded transition-all duration-300"></span>
                    <span class="hamburger-bar block w-5 h-0.5 bg-slate-700 rounded transition-all duration-300"></span>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Drawer --}}
        <div id="mobileMenu"
             class="md:hidden overflow-hidden transition-all duration-300 ease-in-out"
             style="max-height: 0;">
            <div class="px-5 pb-5 pt-2 flex flex-col gap-1 border-t border-slate-100/60">
                <a href="#about"
                   class="mobile-nav-link flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition text-sm">
                    <i class="fa-solid fa-circle-info w-4 text-blue-400 text-center"></i> Cara Kerja
                </a>
                <a href="{{ request()->is('/') ? '#fitur' : url('/#fitur') }}"
                   class="mobile-nav-link flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition text-sm">
                    <i class="fa-solid fa-cubes w-4 text-blue-400 text-center"></i> Fitur Sistem
                </a>
                @guest
                    <hr class="border-slate-100 my-1">
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition text-sm">
                        <i class="fa-solid fa-right-to-bracket w-4 text-blue-400 text-center"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex items-center justify-center gap-2 mx-1 mt-1 py-3 rounded-xl font-bold text-sm bg-slate-900 text-white hover:bg-blue-700 transition shadow-md">
                        Daftar Sekarang
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-24 pb-20 lg:pt-32 lg:pb-32 overflow-hidden">
        <div class="container mx-auto px-6 lg:px-20 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2 text-center lg:text-left">
                    <span class="bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest border border-blue-200">Medical Computation Engine</span>
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 mt-6 leading-tight">
                        Diagnosa <br> <span class="text-blue-600">Mata Anda Sekarang!</span>
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

    <!-- Cara Kerja -->
    <section id="about" class="py-20 lg:py-24 bg-slate-900 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-emerald-600/10 rounded-full blur-[100px]"></div>
        <div class="container mx-auto px-6 lg:px-20 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl lg:text-4xl font-extrabold tracking-tight text-white mb-4">Bagaimana Sistem Bekerja?</h2>
                <p class="text-slate-400 text-sm lg:text-base">Proses skrining menggunakan teknologi <em>Computer Vision</em> yang menganalisis citra mata secara <em>real-time</em> dengan arsitektur Deep Learning.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                <div class="hidden md:block absolute top-10 left-1/6 right-1/6 h-0.5 bg-gradient-to-r from-slate-700 via-blue-500/50 to-slate-700 z-0"></div>
                <div class="relative text-center group z-10">
                    <div class="w-20 h-20 mx-auto bg-slate-800 rounded-3xl flex items-center justify-center mb-6 border border-slate-700 group-hover:border-blue-500 group-hover:-translate-y-2 transition-all duration-300 shadow-xl">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-blue-400"></i>
                        <span class="absolute -top-2 -right-2 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-sm font-bold border-4 border-slate-900 shadow-sm">1</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Input & Akuisisi Citra</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Sistem meminta data usia pasien dan citra mata. Pastikan foto diambil dengan pencahayaan terang dan fokus langsung pada area bola mata.</p>
                </div>
                <div class="relative text-center group z-10">
                    <div class="w-20 h-20 mx-auto bg-slate-800 rounded-3xl flex items-center justify-center mb-6 border border-slate-700 group-hover:border-blue-500 group-hover:-translate-y-2 transition-all duration-300 shadow-xl">
                        <i class="fa-solid fa-microchip text-3xl text-blue-400"></i>
                        <span class="absolute -top-2 -right-2 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-sm font-bold border-4 border-slate-900 shadow-sm">2</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Pemrosesan AI</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Citra dipertajam <em>(enhancement)</em> dan dipotong otomatis. Model TensorFlow AI mencocokkan pola piksel dengan ribuan dataset klinis.</p>
                </div>
                <div class="relative text-center group z-10">
                    <div class="w-20 h-20 mx-auto bg-slate-800 rounded-3xl flex items-center justify-center mb-6 border border-slate-700 group-hover:border-blue-500 group-hover:-translate-y-2 transition-all duration-300 shadow-xl">
                        <i class="fa-solid fa-file-medical text-3xl text-blue-400"></i>
                        <span class="absolute -top-2 -right-2 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-sm font-bold border-4 border-slate-900 shadow-sm">3</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Hasil & Tindak Lanjut</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Menerima lembar hasil berupa persentase Confidence Factor (CF), klasifikasi penyakit, rekomendasi perawatan mandiri, dan lensa kacamata.</p>
                </div>
            </div>
            <div class="mt-20 pt-10 border-t border-slate-800 grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <div>
                    <p class="text-2xl font-black text-blue-400">CNN</p>
                    <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold">Arsitektur AI</p>
                </div>
                <div>
                    <p class="text-2xl font-black text-emerald-400">Real-time</p>
                    <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold">Pemrosesan</p>
                </div>
                <div>
                    <p class="text-2xl font-black text-blue-400">8 Kelas</p>
                    <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold">Deteksi Visual</p>
                </div>
                <div>
                    <p class="text-2xl font-black text-blue-400">&lt; 5 Detik</p>
                    <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold">Waktu Analisis</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur -->
    <section id="fitur" class="pt-20 pb-12 lg:pt-24 lg:pb-20 bg-slate-50">
        <div class="container mx-auto px-6 lg:px-20">
            <div class="text-center max-w-2xl mx-auto mb-16 lg:mb-20">
                <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-4">
                    <i class="fa-solid fa-cubes"></i> Ekosistem Layanan
                </span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">Modul & Fitur Pemeriksaan</h2>
                <p class="text-slate-500 mt-4 text-sm lg:text-base leading-relaxed">Platform ini mengintegrasikan berbagai instrumen penapisan kesehatan mata digital yang komprehensif, aman, dan dapat diakses kapan saja secara mandiri.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <div class="group p-6 bg-white rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition-colors duration-300">
                            <i class="fa-solid fa-robot text-2xl text-blue-600 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <h3 class="text-lg font-black mb-2 text-slate-800">Skrining Oftalmologi AI</h3>
                        <p class="text-slate-600 leading-relaxed text-xs">Analisis struktur fisik luar bola mata menggunakan algoritma <em>Deep Learning</em> (CNN) untuk mendeteksi indikasi klinis awal seperti Katarak, Pterygium, Bintitan, Iritasi, dan Hemorrhage melalui unggahan foto secara otomatis.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-blue-600">
                        <span>Akurasi Tinggi</span>
                        <i class="fa-solid fa-chevron-right group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
                <div class="group p-6 bg-white rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 bg-cyan-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-cyan-500 transition-colors duration-300">
                            <i class="fa-solid fa-glasses text-2xl text-cyan-600 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <h3 class="text-lg font-black mb-2 text-slate-800">Tes Penglihatan Minus/Plus</h3>
                        <p class="text-slate-600 leading-relaxed text-xs">Modul uji ketajaman visus interaktif mandiri yang dikembangkan untuk membantu mengevaluasi adanya gangguan fokus refraksi cahaya, berupa risiko rabun jauh (Miopi) atau rabun dekat (Hipermetropi) secara digital.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-cyan-600">
                        <span>Evaluasi Lensa</span>
                        <i class="fa-solid fa-chevron-right group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
                <div class="group p-6 bg-white rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-500 transition-colors duration-300">
                            <i class="fa-solid fa-palette text-2xl text-purple-600 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <h3 class="text-lg font-black mb-2 text-slate-800">Skrining Buta Warna</h3>
                        <p class="text-slate-600 leading-relaxed text-xs">Pengujian persepsi visual spektrum warna berbasis metode diagram Ishihara digital terintegrasi. Berfungsi memetakan sensitivitas sel fotoreseptor retina dalam mendeteksi gejala buta warna parsial maupun total.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-purple-600">
                        <span>Metode Ishihara</span>
                        <i class="fa-solid fa-chevron-right group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
                <div class="group p-6 bg-white rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-500 transition-colors duration-300">
                            <i class="fa-solid fa-folder-open text-2xl text-emerald-600 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <h3 class="text-lg font-black mb-2 text-slate-800">Rekam Medis & Laporan PDF</h3>
                        <p class="text-slate-600 leading-relaxed text-xs">Pusat penyimpanan riwayat pemeriksaan klinis terpadu yang aman. Menyediakan fitur manipulasi data massal <em>(bulk actions)</em> serta kapabilitas ekspor dokumen laporan rekam medis resmi ke format cetak PDF.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-emerald-600">
                        <span>Manajemen Data Terbuka</span>
                        <i class="fa-solid fa-chevron-right group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 pt-6 pb-12 text-center relative">
        <div class="container mx-auto px-6 text-center">
            <p class="font-bold text-slate-400 uppercase tracking-[0.2em] text-[10px] mb-4">Proyek Praktik Sistem Cerdas - 2026</p>
            <div class="flex justify-center gap-6 text-slate-300 text-xl mb-8">
                <i class="fa-brands fa-github hover:text-slate-900 cursor-pointer"></i>
                <i class="fa-brands fa-laravel hover:text-red-500 cursor-pointer"></i>
                <i class="fa-brands fa-python hover:text-blue-500 cursor-pointer"></i>
            </div>
            <p class="text-slate-500 text-xs">© 2026 <strong>Sistem Pakar Pendeteksi Gangguan Mata</strong>. Dirancang untuk edukasi dan bantuan medis berbasis komputasi.</p>
        </div>
    </footer>

    <!-- FAB: Cek Mata -->
    <a href="{{ route('diagnosa.index') }}"
       id="fabCekMata"
       aria-label="Cek kesehatan mata Anda"
       class="group fixed bottom-5 left-5 z-50 flex items-center gap-3 rounded-full bg-teal-600 py-2.5 pl-2.5 pr-5 text-white shadow-lg shadow-teal-600/30 ring-1 ring-teal-500/40 transition-all duration-300 hover:bg-teal-700 hover:shadow-xl hover:shadow-teal-700/40 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-300 sm:bottom-8 sm:left-8">

        {{-- Tooltip "Cek Mata Anda di Sini" — dikontrol via JS + CSS --}}
        <span id="fabTooltip"
              class="pointer-events-none absolute bottom-full left-2 mb-3 w-max rounded-xl border border-teal-400/30 bg-slate-900/90 px-3 py-1.5 text-[11px] font-semibold text-white shadow-lg backdrop-blur-sm
                     fab-tooltip-hidden">
            Cek Mata Anda di Sini
            <span class="absolute -bottom-1 left-6 h-2 w-2 rotate-45 border-b border-r border-teal-400/30 bg-slate-900/90"></span>
        </span>

        <span class="relative flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white/15">
            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-white/20"></span>
            <svg class="relative h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1 1 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178a1 1 0 010 .644C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </span>
        <span class="flex flex-col leading-tight">
            <span class="text-sm font-bold">Cek Mata</span>
            <span class="text-[11px] font-medium text-teal-100">Diagnosa cepat</span>
        </span>
    </a>

    <!-- ============================================= -->
    <!-- HINT TAB — selalu terlihat di tepi kanan      -->
    <!-- ============================================= -->
    <div class="doctor-hint-tab" id="doctorHintTab" title="Klik untuk lihat dokter">
        <i class="fa-solid fa-user-doctor"></i>
    </div>

    <!-- ============================================= -->
    <!-- DOKTER FLOATING — HIDE/SHOW                   -->
    <!-- ============================================= -->
    <div class="decor-right" id="doctorWidget">

        {{-- Chat Bubble --}}
        <div class="doctor-chat-bubble">
            <span class="wave-hand">👋</span>
            Hai, ada apa dengan matamu
            <strong>{{ Auth::check() ? Auth::user()->name : 'Teman' }}</strong>?
        </div>

        {{-- Gambar Dokter --}}
        <img src="{{ asset('images/doctor-image2.png') }}"
             alt="Dokter Ahli Oftalmologi EyeExpert"
             class="doctor-standing-img">
    </div>

    <!-- ============================================= -->
    <!-- JAVASCRIPT                                    -->
    <!-- ============================================= -->
    <script>
        /* ---------- 1. DOKTER HIDE/SHOW SYSTEM ---------- */
        (function () {
            const doctor   = document.getElementById('doctorWidget');
            const hintTab  = document.getElementById('doctorHintTab');
            if (!doctor) return;

            let introTimer  = null;
            let hideTimer   = null;
            let isHovered   = false;
            let isVisible   = false;

            const INTRO_SHOW = 3500;  // lama tampil saat pertama buka (ms)
            const HIDE_DELAY = 400;   // jeda sebelum sembunyi setelah hover keluar

            /* Fungsi: tampilkan dokter + sembunyikan hint tab */
            function showDoctor() {
                clearTimeout(hideTimer);
                isVisible = true;
                // Pastikan transition aktif dulu sebelum class ditambah
                doctor.style.transition = 'transform 0.45s ease-in-out';
                // Beri sedikit jeda agar browser bisa register transition
                requestAnimationFrame(() => {
                    doctor.classList.add('is-visible');
                    if (hintTab) hintTab.classList.add('is-hidden');
                });
            }

            /* Fungsi: sembunyikan dokter + tampilkan hint tab */
            function hideDoctor(delay = 0) {
                hideTimer = setTimeout(() => {
                    if (!isHovered) {
                        isVisible = false;
                        // Matikan animasi float, aktifkan transition slide keluar
                        doctor.style.animation = 'none';
                        doctor.style.transition = 'transform 0.45s ease-in-out';
                        requestAnimationFrame(() => {
                            doctor.classList.remove('is-visible');
                            if (hintTab) hintTab.classList.remove('is-hidden');
                        });
                        // Setelah slide selesai, bersihkan override style agar CSS class bisa atur ulang
                        setTimeout(() => {
                            doctor.style.animation = '';
                            doctor.style.transition = '';
                        }, 450);
                    }
                }, delay);
            }

            /* --- INTRO: muncul saat halaman pertama dibuka --- */
            showDoctor();
            introTimer = setTimeout(() => {
                if (!isHovered) hideDoctor();
            }, INTRO_SHOW);

            /* --- DESKTOP: hover pada dokter --- */
            doctor.addEventListener('mouseenter', () => {
                isHovered = true;
                clearTimeout(introTimer);
                showDoctor();
            });

            doctor.addEventListener('mouseleave', () => {
                isHovered = false;
                hideDoctor(HIDE_DELAY);
            });

            /* --- DESKTOP: hover pada hint tab juga trigger --- */
            if (hintTab) {
                hintTab.addEventListener('mouseenter', () => {
                    isHovered = true;
                    clearTimeout(introTimer);
                    showDoctor();
                });
                hintTab.addEventListener('mouseleave', () => {
                    isHovered = false;
                    hideDoctor(HIDE_DELAY);
                });
            }

            /* --- MOBILE/CLICK: klik hint tab untuk toggle --- */
            if (hintTab) {
                hintTab.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (isVisible) {
                        isHovered = false;
                        hideDoctor(0);
                    } else {
                        showDoctor();
                    }
                });
            }

            /* --- MOBILE: tap pada dokter untuk toggle --- */
            doctor.addEventListener('touchstart', () => {
                if (isVisible) {
                    isHovered = false;
                    hideDoctor(0);
                } else {
                    showDoctor();
                }
            }, { passive: true });
        })();


        /* ---------- 2. FAB TOOLTIP SHOW/HIDE ---------- */
        (function () {
            const fab     = document.getElementById('fabCekMata');
            const tooltip = document.getElementById('fabTooltip');
            if (!fab || !tooltip) return;

            let introTimer = null;
            let hideTimer  = null;

            function showTooltip() {
                clearTimeout(hideTimer);
                tooltip.classList.remove('fab-tooltip-hidden');
                tooltip.classList.add('fab-tooltip-visible');
            }

            function hideTooltip(delay = 0) {
                hideTimer = setTimeout(() => {
                    tooltip.classList.remove('fab-tooltip-visible');
                    tooltip.classList.add('fab-tooltip-hidden');
                }, delay);
            }

            /* Muncul saat halaman baru dibuka */
            showTooltip();
            introTimer = setTimeout(() => hideTooltip(), 3500);

            /* Hover: tampilkan lagi */
            fab.addEventListener('mouseenter', () => {
                clearTimeout(introTimer);
                showTooltip();
            });
            fab.addEventListener('mouseleave', () => hideTooltip(300));

            /* Touch: tap FAB toggle tooltip */
            fab.addEventListener('touchstart', () => {
                const isShowing = tooltip.classList.contains('fab-tooltip-visible');
                if (isShowing) hideTooltip(0);
                else showTooltip();
            }, { passive: true });
        })();


        /* ---------- 3. MOBILE HAMBURGER MENU ---------- */
        (function () {
            const btn        = document.getElementById('mobileMenuBtn');
            const menu       = document.getElementById('mobileMenu');
            const mobileLinks = document.querySelectorAll('.mobile-nav-link');
            if (!btn || !menu) return;

            function openMenu() {
                menu.style.maxHeight = menu.scrollHeight + 'px';
                btn.classList.add('is-open');
                btn.setAttribute('aria-label', 'Tutup menu');
            }

            function closeMenu() {
                menu.style.maxHeight = '0';
                btn.classList.remove('is-open');
                btn.setAttribute('aria-label', 'Buka menu');
            }

            btn.addEventListener('click', () => {
                if (btn.classList.contains('is-open')) closeMenu();
                else openMenu();
            });

            /* Tutup menu saat link diklik */
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => closeMenu());
            });
        })();


        /* ---------- 4. NAVIGASI HIGHLIGHT ---------- */
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            link.addEventListener('click', function () {
                navLinks.forEach(l => { l.classList.remove('text-blue-600'); l.classList.add('text-slate-600'); });
                this.classList.remove('text-slate-600');
                this.classList.add('text-blue-600');
            });
        });

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                if (window.pageYOffset >= section.offsetTop - 200) current = section.getAttribute('id');
            });
            navLinks.forEach(link => {
                link.classList.remove('text-blue-600');
                link.classList.add('text-slate-600');
                if (current && link.getAttribute('href').includes(current)) {
                    link.classList.remove('text-slate-600');
                    link.classList.add('text-blue-600');
                }
            });
        });


        /* ---------- 4. DROPDOWN USER ---------- */
        const dropdownBtn  = document.getElementById('dropdownUserButton');
        const dropdownMenu = document.getElementById('dropdownUserMenu');

        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });
            window.addEventListener('click', () => dropdownMenu.classList.add('hidden'));
        }


        /* ---------- 5. MODAL DIAGNOSA (jika ada) ---------- */
        const openBtn  = document.getElementById('openDiagnosaModal');
        const closeBtn = document.getElementById('closeDiagnosaModal');
        const modalBox = document.getElementById('diagnosaModal');

        if (openBtn && modalBox) {
            openBtn.addEventListener('click', () => modalBox.classList.remove('hidden'));
            if (closeBtn) closeBtn.addEventListener('click', () => modalBox.classList.add('hidden'));
            modalBox.addEventListener('click', (e) => { if (e.target === modalBox) modalBox.classList.add('hidden'); });
        }
    </script>

</body>
</html>