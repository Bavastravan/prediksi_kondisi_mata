<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-lg shadow-blue-200">
                            <i class="fa-solid fa-eye text-xl"></i>
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight text-blue-900">Eye<span class="text-blue-600">Expert.</span></span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex h-16">
                    <a href="{{ url('/') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') || request()->path() == '/' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-slate-500 hover:text-blue-600' }} text-sm transition">
                        Beranda
                    </a>

                    @if(request()->routeIs('diagnosa.*'))
                        <x-nav-link :href="route('diagnosa.index')" :active="request()->routeIs('diagnosa.*')">
                            Diagnosa Oftalmologi
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('gejala.mata')" :active="request()->routeIs('gejala.mata')">
                            Gejala Mata
                        </x-nav-link>
                        <x-nav-link :href="route('penyakit-mata')" :active="request()->routeIs('penyakit-mata')">
                            Penyakit Mata
                        </x-nav-link>
                        <x-nav-link :href="route('pencegahan-mata')" :active="request()->routeIs('pencegahan-mata')">
                            Pencegahan
                        </x-nav-link>
                        <x-nav-link :href="route('kacamata')" :active="request()->routeIs('kacamata')">
                            Kacamata
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center">
                <link class="hidden" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
                
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

                        <div id="dropdownUserMenu" class="hidden absolute right-0 mt-2.5 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 transform origin-top-right transition duration-200">
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
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-blue-600 font-bold text-sm transition">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-full font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-100 transition">Daftar</a>
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Beranda') }}
            </x-responsive-nav-link>
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-slate-100 bg-slate-50/50 rounded-b-2xl">
                <div class="px-4 mb-2 flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold text-sm text-slate-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-xs text-slate-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1 px-2">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition">
                        <i class="fa-solid fa-user-gear text-slate-400"></i> {{ __('Profile') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition text-left">
                            <i class="fa-solid fa-right-from-bracket text-red-400"></i> {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-4 border-t border-slate-100 px-4 flex flex-col gap-2">
                <a href="{{ route('login') }}" class="text-center text-slate-600 font-bold py-2 rounded-xl hover:bg-slate-50 text-sm transition">Masuk</a>
                <a href="{{ route('register') }}" class="text-center bg-blue-600 text-white font-bold py-2 rounded-xl text-sm shadow-md transition">Daftar</a>
            </div>
        @endauth
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userBtn = document.getElementById('dropdownUserButton');
        const userMenu = document.getElementById('dropdownUserMenu');

        if (userBtn && userMenu) {
            userBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });

            window.addEventListener('click', function() {
                userMenu.classList.add('hidden');
            });
        }
    });
</script>