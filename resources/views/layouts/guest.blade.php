<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Jarochos Pizza</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white">
        <div class="min-h-screen flex" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
            
            <!-- Left Side - Elegant Image -->
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gray-900">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[20s] ease-out transform hover:scale-110" 
                     style="background-image: url('https://images.unsplash.com/photo-1513104890138-7c749659a591?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                </div>
                <div class="absolute inset-0 bg-black/40"></div>
                
                <div class="relative z-10 w-full flex flex-col justify-center px-12 text-white">
                    <div x-show="show" 
                         x-transition:enter="transition ease-out duration-1000 delay-300"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h1 class="text-6xl font-bold font-serif mb-6 leading-tight">
                            Auténtica <br> Pasión <br> <span class="text-red-500">Italiana</span>
                        </h1>
                        <p class="text-xl text-gray-200 font-light max-w-md">
                            Vive el arte de hacer pizza. Ingredientes frescos, recetas atemporales, directo a tu puerta.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Minimalist Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 lg:p-24 bg-white relative">
                <div class="w-full max-w-md space-y-8">
                    <div x-show="show" 
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 -translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="text-center lg:text-left">
                        <a href="/" class="flex flex-col items-center gap-2 group">
                            <img src="{{ asset('img/logo.jpg') }}" alt="Jarochos Pizza Logo" class="h-20 w-20 rounded-full object-cover shadow-lg group-hover:scale-105 transition-transform duration-300">
                            <span class="text-3xl font-bold tracking-tighter text-gray-900 group-hover:text-red-600 transition-colors">
                                JAROCHOS<span class="text-red-600 group-hover:text-gray-900">PIZZA</span>
                            </span>
                        </a>
                    </div>

                    <div x-show="show"
                         x-transition:enter="transition ease-out duration-700 delay-200"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        {{ $slot }}
                    </div>
                    
                    <div x-show="show"
                         x-transition:enter="transition ease-out duration-1000 delay-500"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         class="text-center lg:text-left text-sm text-gray-400 mt-8">
                        &copy; {{ date('Y') }} Jarochos Pizza.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
