<!-- Chat Container (HTML sin cambios, solo el script) -->
<div id="chat-container">
    <button id="chat-toggle"
        class="fixed bottom-16 right-4 z-50 bg-blue-500 hover:bg-blue-600 text-white rounded-full p-4 shadow-lg transition-all duration-200 transform hover:scale-105">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
            </path>
        </svg>
    </button>

    <div id="chat-window"
        class="fixed bottom-16 right-4 w-80 h-[40rem] bg-white rounded-lg shadow-2xl z-50 flex flex-col border border-gray-200 hidden">
        <div class="bg-blue-500 text-white p-4 rounded-t-lg flex justify-between items-center">
            <div class="flex items-center">
                <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                <h3 class="font-semibold">Asistente Técnico Virtual</h3>
            </div>
            <div class="flex space-x-2">
                <button id="chat-clear" class="text-white hover:text-gray-200 transition-colors" title="Limpiar chat">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </button>
                <button id="chat-close" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50">
            <!-- Mensajes se agregan dinámicamente -->
        </div>

        {{-- <div class="p-3 border-t border-gray-200 bg-white rounded-b-lg">
            <div class="flex space-x-2">
                <input id="chat-input" type="text" placeholder="Escribe tu mensaje..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button id="chat-send" class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg px-3 py-2 transition-colors flex items-center justify-center min-w-[40px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
            <div class="text-xs text-gray-500 mt-2 text-center">
                Presiona Enter para enviar
            </div>
        </div> --}}

        <div class="p-3 border-t border-gray-200 bg-white rounded-b-lg">
            <div class="flex items-center space-x-2">                

                <!-- Campo de texto del chat -->
                <input id="chat-input" type="text" placeholder="Escribe tu mensaje..."
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent h-[38px]">

                <!-- Botón de enviar -->
                <button id="chat-send"
                    class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg px-3 py-2 transition-colors flex items-center justify-center h-[38px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>

            <div class="text-xs text-gray-500 mt-2 text-center">
                Presiona Enter para enviar
                <!-- Botón Registrar Incidencia -->                
            </div>
            <a href="#incidencias"
                    class="bg-gray-400 hover:bg-blue-500 mt-2 text-white rounded-lg px-3 py-2 text-sm transition-colors h-[38px] flex items-center justify-center">
                    💬 Contactar con soporte
                </a>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuración
        const chatContainer = document.getElementById('chat-container');
        const chatToggleBtn = document.getElementById('chat-toggle');
        const chatWindow = document.getElementById('chat-window');
        const chatMessages = document.getElementById('chat-messages');
        const chatInput = document.getElementById('chat-input');
        const chatSendBtn = document.getElementById('chat-send');
        const chatClearBtn = document.getElementById('chat-clear');
        const chatCloseBtn = document.getElementById('chat-close');

        let isOpen = false;
        let isLoading = false;
        let inactivityTimer = null;
        let inactivityTimeout = 60000; // 1 minuto
        let interactionId = null; // ID de interacción para métricas

        // Mensaje de bienvenida
        const welcomeMessage =
            '¡Hola! Soy tu asistente técnico. ¿En qué puedo ayudarte hoy? Puedo ayudarte con problemas de impresoras, internet, computadoras lentas y más.';

        // Función para agregar mensaje
        function addMessage(role, content, modelUsed = null, isFallback = false, timestamp = new Date()
            .toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            })) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${role === 'user' ? 'justify-end' : 'justify-start'} mb-3`;
            messageDiv.innerHTML = `
            <div class="max-w-xs lg:max-w-md">
                <div class="rounded-lg px-3 py-2 ${role === 'user' ? 'bg-blue-500 text-white ml-auto' : 'bg-white text-gray-800 border border-gray-200 shadow-sm'}">
                    <p class="text-sm whitespace-pre-wrap">${content}</p>
                    ${role === 'assistant' && modelUsed ? `<div class="text-xs text-gray-500 mt-1"><span class="opacity-75">${modelUsed}</span></div>` : ''}
                    ${role === 'assistant' && isFallback ? `<div class="text-xs text-yellow-500 mt-1"><span>Respuesta automática</span></div>` : ''}
                    <div class="text-xs ${role === 'user' ? 'text-blue-100' : 'text-gray-400'} mt-1">${timestamp}</div>
                </div>
            </div>
        `;
            chatMessages.appendChild(messageDiv);
            scrollToBottom();
        }

        // Función para scroll al final
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Función para resetear timer de inactividad
        function startInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(() => {
                endInteraction();
                closeChat();
            }, inactivityTimeout);
        }

        // Función para iniciar interacción (métricas)
        async function startInteraction() {
            try {
                const response = await fetch('/tickets/public/api/chatbot/start', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                if (data.success) {
                    interactionId = data.interaction_id;
                    console.log('Interacción iniciada:', interactionId);
                }
            } catch (error) {
                console.error('Error al iniciar interacción:', error);
            }
        }

        // Función para finalizar interacción (métricas)
        async function endInteraction() {
            if (interactionId) {
                try {
                    await fetch('/tickets/public/api/chatbot/end-interaction', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            interaction_id: interactionId
                        })
                    });
                    console.log('Interacción finalizada:', interactionId);
                } catch (error) {
                    console.error('Error al finalizar interacción:', error);
                }
                interactionId = null;
            }
        }

        // Función para enviar mensaje
        async function sendMessage() {
            if (isLoading || !chatInput.value.trim()) return;

            const messageToSend = chatInput.value.trim();
            chatInput.value = '';
            addMessage('user', messageToSend);

            isLoading = true;
            chatSendBtn.disabled = true;
            chatSendBtn.innerHTML =
                '<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            try {
                const response = await fetch('/tickets/public/api/chatbot/message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: messageToSend,
                        interaction_id: interactionId // Enviar ID para métricas
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    addMessage('assistant', data.reply, data.model_used, data.is_fallback);
                } else {
                    addMessage('assistant', 'Lo siento, hubo un problema. Intenta de nuevo.');
                }
            } catch (error) {
                addMessage('assistant', 'Error de conexión. Intenta de nuevo.');
                console.error('Error en sendMessage:', error);
            } finally {
                isLoading = false;
                chatSendBtn.disabled = false;
                chatSendBtn.innerHTML =
                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>';
                startInactivityTimer();
            }
        }

        // Función para limpiar chat
        function clearChat() {
            chatMessages.innerHTML = '';
            addMessage('assistant', welcomeMessage);
            startInactivityTimer();
        }

        // Función para cerrar chat
        function closeChat() {
            isOpen = false;
            chatWindow.classList.add('hidden');
            chatToggleBtn.classList.remove('hidden');
            clearTimeout(inactivityTimer);
            endInteraction(); // Finalizar métricas al cerrar
        }

        // Función para abrir chat
        function openChat() {
            isOpen = true;
            chatWindow.classList.remove('hidden');
            chatToggleBtn.classList.add('hidden');
            chatInput.focus();
            startInteraction(); // Iniciar métricas al abrir
            startInactivityTimer();
        }

        // Event listeners
        chatToggleBtn.addEventListener('click', openChat);
        chatSendBtn.addEventListener('click', sendMessage);
        chatInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
        chatClearBtn.addEventListener('click', clearChat);
        chatCloseBtn.addEventListener('click', closeChat);

        // Inicializar chat cerrado
        chatWindow.classList.add('hidden');
        addMessage('assistant', welcomeMessage);

        // Manejar recarga de página
        window.addEventListener('beforeunload', endInteraction);
    });
</script>
