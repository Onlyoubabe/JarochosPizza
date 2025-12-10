<footer id="contact" class="bg-white border-t border-gray-100 mt-auto pt-20 pb-16">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Col 1: Brand / Stay in touch -->
            <div class="space-y-6">
                <h3 class="text-2xl font-serif text-gray-900 tracking-tight">Jarochos Pizza</h3>
                <div class="space-y-4 text-sm text-gray-500 leading-relaxed">
                    <p>Hecho con <span class="text-red-500">&hearts;</span> en Veracruz.</p>
                    <p>&copy; {{ date('Y') }} Jarochos Pizza.<br>Todos los derechos reservados.</p>
                    <p class="pt-4 text-xs text-gray-400">Ceramics by Jono Pandolfi Designs.</p>
                </div>
            </div>

            <!-- Col 2: Questions? / Contact -->
            <div class="space-y-6">
                <h3 class="text-2xl font-serif text-gray-900 tracking-tight">Dirección</h3>
                <div class="space-y-4 text-sm text-gray-500 leading-relaxed">
                    <p>
                        Av. Manuel Avila Camacho 22,<br>
                        Centro, 93556<br>
                        Gutiérrez Zamora, Ver.<br>
                        <a href="{{ route('about') }}" class="text-red-500 hover:text-red-600 underline mt-2 block w-fit">Conoce más de nosotros &rarr;</a>
                    </p>
                    <div class="flex space-x-4 pt-2">
                        <a href="https://www.facebook.com/macariopizzapap" target="_blank" class="text-gray-400 hover:text-gray-900 transition">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/jarochos.pizza/" target="_blank" class="text-gray-400 hover:text-gray-900 transition">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465C9.673 2.013 10.03 2 12.48 2h-1.65zm-1.87 1.666c-2.583 0-2.903.01-3.921.056-1.012.047-1.558.212-1.921.353-.477.185-.818.406-1.176.763-.357.358-.578.699-.763 1.176-.14.363-.306.91-.353 1.92-.047 1.019-.057 1.338-.057 3.921l.006.582c0 2.504.01 2.898.056 3.921.047 1.012.212 1.558.353 1.921.185.477.406.818.763 1.176.358.357.699.578 1.176.763.363.14.91.306 1.921.353 1.019.046 1.338.056 3.921.056.88 0 1.258.006 1.258.006s.379-.006 1.258-.006c2.583 0 2.903-.01 3.921-.056 1.012-.047 1.558-.212 1.921-.353.477-.185.818-.406 1.176-.763.357-.358.578-.699.763-1.176.14-.363.306-.91.353-1.921.046-1.019.056-1.338.056-3.921l-.005-.582c0-2.505-.01-2.899-.056-3.921-.047-1.012-.212-1.558-.353-1.921-.185-.477-.406-.818-.763-1.176-.358-.357-.699-.578-1.176-.763-.363-.14-.91-.306-1.921-.353-1.019-.047-1.338-.057-3.921-.057h-1.258zm1.096 3.235a5.332 5.332 0 110 10.664 5.332 5.332 0 010-10.664zm0 1.666a3.666 3.666 0 100 7.332 3.666 3.666 0 000-7.332zm5.727-4.103a1.11 1.11 0 110 2.22 1.11 1.11 0 010-2.22z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Col 3: Navegación -->
            <div class="space-y-6">
                <h3 class="text-2xl font-serif text-gray-900 tracking-tight">Menú.</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-red-500 transition border-b border-transparent hover:border-red-500 pb-0.5">Inicio</a></li>
                    <li><a href="{{ route('home') }}#menu" class="text-sm text-gray-500 hover:text-red-500 transition border-b border-transparent hover:border-red-500 pb-0.5">Pizzas</a></li>
                    @auth
                        <li><a href="{{ route('orders.index') }}" class="text-sm text-gray-500 hover:text-red-500 transition border-b border-transparent hover:border-red-500 pb-0.5">Mis Pedidos</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-gray-500 hover:text-red-500 transition border-b border-transparent hover:border-red-500 pb-0.5">Salir</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-red-500 transition border-b border-transparent hover:border-red-500 pb-0.5">Entrar</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-red-500 transition border-b border-transparent hover:border-red-500 pb-0.5">Registro</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </div>
</footer>
