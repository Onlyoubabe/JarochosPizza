<div x-data="{
    isOpen: false,
    messages: [
        { text: '¡Hola! 🍕 Soy el asistente virtual de Jarochos Pizza. ¿En qué puedo ayudarte hoy?', isBot: true }
    ],
    isTyping: false,
    options: [
        { label: '🍕 Ver Menú', action: 'menu' },
        { label: '📍 Ubicación', action: 'location' },
        { label: '⏰ Horarios', action: 'hours' },
        { label: '📞 Contacto', action: 'contact' }
    ],
    lastScrollHeight: 0,

    init() {
        // Scroll to bottom on new message
        this.$watch('messages', () => {
            this.$nextTick(() => {
                const chatContainer = this.$refs.chatContainer;
                chatContainer.scrollTop = chatContainer.scrollHeight;
            });
        });
    },

    toggleChat() {
        this.isOpen = !this.isOpen;
    },

    handleOption(option) {
        // Add user message
        this.addMessage(option.label, false);

        // Simulate typing delay
        this.isTyping = true;
        setTimeout(() => {
            this.isTyping = false;
            this.respond(option.action);
        }, 800);
    },

    addMessage(text, isBot) {
        this.messages.push({ text, isBot });
    },

    respond(action) {
        let response = '';
        switch(action) {
            case 'menu':
                response = '¡Claro! Tenemos las mejores pizzas artesanales. <a href=\'{{ route('home') }}#menu\' class=\'underline text-red-500 font-bold\'>Haz clic aquí para ver nuestro menú completo</a>.';
                break;
            case 'location':
                response = 'Estamos ubicados en: <br><strong>Av. Manuel Avila Camacho 22, Centro, 93556 Gutiérrez Zamora, Ver.</strong> <br><a href=\'{{ route('about') }}#map\' class=\'underline text-red-500\'>Ver en el mapa</a>';
                break;
            case 'hours':
                response = 'Nuestro horario es:<br>🗓️ <strong>Lunes a Domingo</strong><br>⏰ 1:00 PM - 11:00 PM';
                break;
            case 'contact':
                response = 'Puedes contactarnos por:<br>📞 Teléfono: (123) 456-7890<br>📱 <a href=\'https://wa.me/YOURNUMBER\' target=\'_blank\' class=\'underline text-green-500\'>WhatsApp</a><br>👍 <a href=\'https://www.facebook.com/macariopizzapap\' target=\'_blank\' class=\'underline text-blue-600\'>Facebook</a>';
                break;
            default:
                response = 'Lo siento, no entendí eso. ¿Podrías elegir una de las opciones?';
        }
        this.addMessage(response, true);
    }
}" 
class="fixed bottom-6 right-6 z-50 flex flex-col items-end space-y-4 font-sans">

    <!-- Chat Window -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="bg-white w-80 sm:w-96 rounded-2xl shadow-2xl border border-gray-200 overflow-hidden flex flex-col max-h-[500px]">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-red-600 to-orange-500 p-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-3">
                <div class="bg-white p-1 rounded-full shadow-inner overflow-hidden">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Bot Logo" class="w-8 h-8 object-cover">
                </div>
                <div>
                    <h3 class="font-bold text-white tracking-wide text-sm">Asistente Jarochos Pizza</h3>
                    <p class="text-red-100 text-xs flex items-center">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></span> En línea
                    </p>
                </div>
            </div>
            <button @click="toggleChat" class="text-white hover:bg-white/20 rounded-full p-1 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div x-ref="chatContainer" class="flex-1 p-4 overflow-y-auto bg-gray-50 space-y-4 min-h-[300px]">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.isBot ? 'flex justify-start' : 'flex justify-end'">
                    <div :class="msg.isBot ? 'bg-white border border-gray-100 text-gray-800 rounded-tl-none' : 'bg-red-500 text-white rounded-tr-none'" 
                         class="max-w-[85%] rounded-2xl px-4 py-2.5 shadow-sm text-sm leading-relaxed"
                         x-html="msg.text">
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex justify-start">
                <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-none px-4 py-3 shadow-sm flex space-x-1 items-center">
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                </div>
            </div>
        </div>

        <!-- Options Area -->
        <div class="p-4 bg-white border-t border-gray-100 z-10">
            <p class="text-xs text-gray-400 mb-3 text-center uppercase tracking-wider font-semibold">Opciones Rápidas</p>
            <div class="grid grid-cols-2 gap-2">
                <template x-for="opt in options">
                    <button @click="handleOption(opt)" 
                            class="text-xs sm:text-sm font-medium py-2 px-3 rounded-lg border border-gray-200 text-gray-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition duration-200 text-center flex items-center justify-center space-x-1">
                        <span x-text="opt.label"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- Toggle Button -->
    <button @click="toggleChat" 
            :class="isOpen ? 'scale-0 opacity-0' : 'scale-100 opacity-100'"
            class="bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-700 hover:to-orange-600 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-red-300 group">
        <!-- Icon Closed -->
        <svg class="w-8 h-8 relative group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-4 w-4">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 border-2 border-white"></span>
        </span>
    </button>
</div>
