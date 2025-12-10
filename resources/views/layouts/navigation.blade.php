<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold text-red-600 tracking-tighter">
                        <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="h-10 w-10 object-cover rounded-full">
                        <span>JAROCHOS<span class="text-gray-800">PIZZA</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') && !request()->has('menu') ? 'border-red-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                        Inicio
                    </a>
                    <a href="{{ route('home') }}#menu" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                        Menú
                    </a>
                    @if(!auth()->user()?->isAdmin() && !auth()->user()?->isEmployee())
                        <a href="{{ route('about') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('about') ? 'border-red-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                            Nosotros
                        </a>
                        <a href="#contact" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                            Contacto
                        </a>
                    @endif
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-red-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                            Panel de Control
                        </a>
                        @if(!Auth::user()->isAdmin() && !Auth::user()->isEmployee())
                            <a href="{{ route('orders.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('orders.index') ? 'border-red-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Mis Pedidos
                            </a>
                        @endif
                        
                        @if(Auth::user()->isAdmin() || Auth::user()->isEmployee())
                            <a href="{{ route('admin.orders.create') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.orders.create') ? 'border-red-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                POS
                            </a>
                        @endif
                        
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.users.create') ? 'border-red-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Usuarios
                            </a>
                            <a href="{{ route('admin.pizzas.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.pizzas.index') ? 'border-red-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Pizzas
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                @if(!auth()->user()?->isAdmin() && !auth()->user()?->isEmployee())
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Carrito</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                @endif

                @auth
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                        <div @click="open = ! open">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </div>

                        <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right bg-white ring-1 ring-black ring-opacity-5 py-1"
                                style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar Sesión</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-full transition">Registrarse</a>
                @endauth
            </div>

            <!-- Hamburger -->
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

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('home').'#menu'">
                {{ __('Menú') }}
            </x-responsive-nav-link>
            @if(!auth()->user()?->isAdmin() && !auth()->user()?->isEmployee())
                <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                    {{ __('Nosotros') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="#contact">
                    {{ __('Contacto') }}
                </x-responsive-nav-link>
            @endif
            
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Panel de Control') }}
                </x-responsive-nav-link>
                @if(!Auth::user()->isAdmin() && !Auth::user()->isEmployee())
                    <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                        {{ __('Mis Pedidos') }}
                    </x-responsive-nav-link>
                @endif
                
                @if(Auth::user()->isAdmin())
                     <x-responsive-nav-link :href="route('admin.pizzas.index')" :active="request()->routeIs('admin.pizzas.index')">
                        {{ __('Gestión de Pizzas') }}
                    </x-responsive-nav-link>
                @endif
            @else
                 <x-responsive-nav-link :href="route('login')">
                    {{ __('Iniciar Sesión') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Registrarse') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
