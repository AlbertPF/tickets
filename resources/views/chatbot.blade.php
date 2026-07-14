<style>
    #chat-window {
        width: min(390px, calc(100vw - 2rem));
        height: min(680px, calc(100vh - 6rem));
        animation: chat-panel-in 180ms ease-out;
    }

    #chat-messages {
        background:
            radial-gradient(circle at 10% 0%, rgba(56, 101, 168, 0.08), transparent 32%),
            #f7f9fc;
        scrollbar-color: #cbd5e1 transparent;
        scrollbar-width: thin;
    }

    #chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    #chat-messages::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }

    .chat-message-enter {
        animation: chat-message-in 180ms ease-out;
    }

    .chat-typing-dot {
        width: 6px;
        height: 6px;
        border-radius: 999px;
        background: #7c8aa0;
        animation: chat-typing 1.2s infinite ease-in-out;
    }

    .chat-typing-dot:nth-child(2) {
        animation-delay: 150ms;
    }

    .chat-typing-dot:nth-child(3) {
        animation-delay: 300ms;
    }

    @keyframes chat-panel-in {
        from {
            opacity: 0;
            transform: translateY(10px) scale(0.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes chat-message-in {
        from {
            opacity: 0;
            transform: translateY(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes chat-typing {

        0%,
        60%,
        100% {
            transform: translateY(0);
            opacity: 0.45;
        }

        30% {
            transform: translateY(-3px);
            opacity: 1;
        }
    }

    @media (max-width: 640px) {
        #chat-window {
            right: 1rem;
            bottom: 1rem;
            height: calc(100vh - 2rem);
        }
    }

    @media (prefers-reduced-motion: reduce) {

        #chat-window,
        .chat-message-enter,
        .chat-typing-dot {
            animation: none;
        }
    }
</style>

<div id="chat-container">
    <button id="chat-toggle" type="button" aria-label="Abrir asistente técnico" aria-controls="chat-window"
        aria-expanded="false"
        class="group fixed bottom-16 right-4 z-[9999] flex h-14 w-14 items-center justify-center rounded-2xl border-0 bg-[#3865a8] p-0 text-white shadow-[0_12px_32px_rgba(35,75,132,0.35)] transition duration-200 hover:-translate-y-1 hover:bg-[#2f578f] focus:outline-none focus:ring-4 focus:ring-blue-200">
        <i class="bi bi-chat-dots-fill text-2xl transition-transform duration-200 group-hover:scale-110"
            aria-hidden="true"></i>
        <span class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-white shadow">
            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
        </span>
    </button>

    <section id="chat-window" role="dialog" aria-labelledby="chat-title" aria-describedby="chat-description"
        class="fixed bottom-16 right-4 z-[9999] hidden flex-col overflow-hidden rounded-[24px] border border-slate-200/80 bg-white shadow-[0_24px_70px_rgba(15,23,42,0.22)]">
        <header
            class="relative overflow-hidden bg-gradient-to-br from-[#3865a8] to-[#244b82] px-4 py-4 text-white">
            <div class="absolute -right-8 -top-10 h-28 w-28 rounded-full bg-white/10"></div>
            <div class="relative flex items-center justify-between gap-3">
                <div class="flex min-w-0 items-center gap-3">
                    <div
                        class="relative flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur-sm">
                        <i class="bi bi-robot text-2xl" aria-hidden="true"></i>
                        <span
                            class="absolute -bottom-0.5 -right-0.5 h-3.5 w-3.5 rounded-full border-2 border-[#315b96] bg-emerald-400"></span>
                    </div>
                    <div class="min-w-0">
                        <h2 id="chat-title" class="m-0 truncate text-[15px] font-semibold leading-tight text-white">
                            Asistente Técnico Virtual
                        </h2>
                        <p id="chat-description"
                            class="m-0 mt-1 flex items-center gap-1.5 text-[11px] text-blue-100">
                            <i class="bi bi-building" aria-hidden="true"></i>
                            GORE Apurímac · Orientación inmediata
                        </p>
                    </div>
                </div>

                <div class="relative flex shrink-0 items-center gap-1">
                    <button id="chat-clear" type="button" aria-label="Limpiar conversación"
                        title="Limpiar conversación"
                        class="flex h-9 w-9 items-center justify-center rounded-xl border-0 bg-white/10 p-0 text-white transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <i class="bi bi-trash3 text-sm" aria-hidden="true"></i>
                    </button>
                    <button id="chat-close" type="button" aria-label="Cerrar asistente" title="Cerrar asistente"
                        class="flex h-9 w-9 items-center justify-center rounded-xl border-0 bg-white/10 p-0 text-white transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <i class="bi bi-x-lg text-sm" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </header>

        <div id="chat-messages" role="log" aria-live="polite" aria-relevant="additions"
            class="flex-1 space-y-4 overflow-y-auto px-4 py-5">
            <div id="chat-typing" class="hidden items-end gap-2.5" aria-label="El asistente está escribiendo">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-[#3865a8]">
                    <i class="bi bi-robot text-sm" aria-hidden="true"></i>
                </div>
                <div
                    class="flex items-center gap-1.5 rounded-2xl rounded-bl-md border border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <span class="chat-typing-dot"></span>
                    <span class="chat-typing-dot"></span>
                    <span class="chat-typing-dot"></span>
                </div>
            </div>
        </div>

        <footer class="border-t border-slate-200 bg-white px-3.5 pb-3.5 pt-3">
            <label for="chat-input" class="sr-only">Escribe tu consulta técnica</label>
            <div
                class="flex items-center gap-2 rounded-2xl border border-slate-300 bg-slate-50 p-1.5 transition focus-within:border-[#3865a8] focus-within:bg-white focus-within:ring-4 focus-within:ring-blue-100">
                <i class="bi bi-chat-left-text ml-2.5 text-sm text-slate-400" aria-hidden="true"></i>
                <input id="chat-input" type="text" maxlength="1000" autocomplete="off"
                    placeholder="Describe tu problema técnico..."
                    class="h-10 min-w-0 flex-1 border-0 bg-transparent px-1 text-sm text-slate-800 outline-none placeholder:text-slate-400 focus:border-0 focus:outline-none focus:ring-0">
                <button id="chat-send" type="button" aria-label="Enviar mensaje"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border-0 bg-[#3865a8] p-0 text-white shadow-sm transition hover:bg-[#2f578f] focus:outline-none focus:ring-2 focus:ring-blue-300 disabled:cursor-not-allowed disabled:opacity-60">
                    <i class="bi bi-send-fill text-sm" aria-hidden="true"></i>
                </button>
            </div>

            <div class="mt-2 flex items-center justify-between px-1 text-[10px] text-slate-400">
                <span class="flex items-center gap-1">
                    <i class="bi bi-shield-lock" aria-hidden="true"></i>
                    No compartas contraseñas
                </span>
                <span>Enter para enviar</span>
            </div>

            <a id="chat-support-link" href="#incidencias"
                class="mt-3 flex h-10 items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-3 text-xs font-semibold text-[#315b96] no-underline transition hover:border-blue-300 hover:bg-blue-100 hover:text-[#244b82]">
                <i class="bi bi-ticket-perforated" aria-hidden="true"></i>
                Crear ticket de soporte
                <i class="bi bi-arrow-right text-[10px]" aria-hidden="true"></i>
            </a>
        </footer>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatToggleBtn = document.getElementById('chat-toggle');
        const chatWindow = document.getElementById('chat-window');
        const chatMessages = document.getElementById('chat-messages');
        const chatInput = document.getElementById('chat-input');
        const chatSendBtn = document.getElementById('chat-send');
        const chatClearBtn = document.getElementById('chat-clear');
        const chatCloseBtn = document.getElementById('chat-close');
        const chatSupportLink = document.getElementById('chat-support-link');
        const chatTyping = document.getElementById('chat-typing');

        let isOpen = false;
        let isLoading = false;
        let inactivityTimer = null;
        const inactivityTimeout = 60000;
        let interactionId = null;

        const chatbotUrls = {
            start: @json(route('api.chatbot.start')),
            message: @json(route('api.chatbot.message')),
            endInteraction: @json(route('api.chatbot.end-interaction')),
        };

        const welcomeMessage =
            '¡Hola! Soy el asistente técnico del GORE Apurímac. Cuéntame qué problema tienes con tu computadora, impresora, red o proyector.';
        const sendButtonMarkup = '<i class="bi bi-send-fill text-sm" aria-hidden="true"></i>';
        const loadingButtonMarkup =
            '<span class="h-4 w-4 animate-spin rounded-full border-2 border-white/40 border-t-white" aria-hidden="true"></span>';

        function addMessage(role, content, modelUsed = null, isFallback = false, timestamp = new Date()
            .toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            })) {
            const isUser = role === 'user';
            const messageRow = document.createElement('div');
            messageRow.dataset.chatMessage = 'true';
            messageRow.className =
                `chat-message-enter flex items-end gap-2.5 ${isUser ? 'flex-row-reverse' : ''}`;

            const avatar = document.createElement('div');
            avatar.className = isUser
                ? 'flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-slate-200 text-slate-600'
                : 'flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-[#3865a8]';
            avatar.innerHTML = isUser
                ? '<i class="bi bi-person-fill text-sm" aria-hidden="true"></i>'
                : '<i class="bi bi-robot text-sm" aria-hidden="true"></i>';

            const messageContent = document.createElement('div');
            messageContent.className = `max-w-[82%] ${isUser ? 'text-right' : 'text-left'}`;

            const bubble = document.createElement('div');
            bubble.className = isUser
                ? 'inline-block rounded-2xl rounded-br-md bg-[#3865a8] px-3.5 py-2.5 text-left text-white shadow-sm'
                : 'inline-block rounded-2xl rounded-bl-md border border-slate-200 bg-white px-3.5 py-2.5 text-left text-slate-700 shadow-sm';

            const messageText = document.createElement('p');
            messageText.className = 'm-0 whitespace-pre-wrap break-words text-[13px] leading-relaxed';
            messageText.textContent = content;
            bubble.appendChild(messageText);

            const metadata = document.createElement('div');
            metadata.className =
                `mt-1.5 flex items-center gap-1.5 text-[9px] ${isUser ? 'justify-end text-blue-100' : 'text-slate-400'}`;

            const clock = document.createElement('i');
            clock.className = 'bi bi-clock';
            clock.setAttribute('aria-hidden', 'true');

            const time = document.createElement('span');
            time.textContent = timestamp;
            metadata.append(clock, time);

            if (!isUser && isFallback) {
                const fallbackBadge = document.createElement('span');
                fallbackBadge.className =
                    'ml-1 rounded-full bg-amber-100 px-1.5 py-0.5 font-medium text-amber-700';
                fallbackBadge.textContent = 'Respuesta automática';
                metadata.appendChild(fallbackBadge);
            } else if (!isUser && modelUsed) {
                const modelBadge = document.createElement('span');
                modelBadge.className = 'ml-1 flex items-center gap-1 text-slate-400';
                modelBadge.title = modelUsed;
                modelBadge.innerHTML = '<i class="bi bi-cpu" aria-hidden="true"></i><span>Asistente IA</span>';
                metadata.appendChild(modelBadge);
            }

            messageContent.append(bubble, metadata);
            messageRow.append(avatar, messageContent);
            chatMessages.appendChild(messageRow);
            scrollToBottom();
        }

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function showTypingIndicator() {
            chatMessages.appendChild(chatTyping);
            chatTyping.classList.remove('hidden');
            chatTyping.classList.add('flex');
            scrollToBottom();
        }

        function hideTypingIndicator() {
            chatTyping.classList.add('hidden');
            chatTyping.classList.remove('flex');
        }

        function setLoading(loading) {
            isLoading = loading;
            chatSendBtn.disabled = loading;
            chatSendBtn.innerHTML = loading ? loadingButtonMarkup : sendButtonMarkup;
            chatInput.setAttribute('aria-busy', loading ? 'true' : 'false');
        }

        function startInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(() => {
                endInteraction();
                closeChat();
            }, inactivityTimeout);
        }

        async function startInteraction() {
            try {
                const response = await fetch(chatbotUrls.start, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                const contentType = response.headers.get('content-type') || '';
                const data = contentType.includes('application/json') ? await response.json() : {};

                if (data.success) {
                    interactionId = data.interaction_id;
                }
            } catch (error) {
                console.error('Error al iniciar interacción:', error);
            }
        }

        async function endInteraction() {
            if (!interactionId) return;

            try {
                await fetch(chatbotUrls.endInteraction, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        interaction_id: interactionId
                    })
                });
            } catch (error) {
                console.error('Error al finalizar interacción:', error);
            }

            interactionId = null;
        }

        async function sendMessage() {
            if (isLoading || !chatInput.value.trim()) return;

            const messageToSend = chatInput.value.trim();
            chatInput.value = '';
            addMessage('user', messageToSend);
            setLoading(true);
            showTypingIndicator();

            try {
                const response = await fetch(chatbotUrls.message, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        message: messageToSend,
                        interaction_id: interactionId
                    })
                });

                const contentType = response.headers.get('content-type') || '';
                const data = contentType.includes('application/json') ? await response.json() : {};

                if (!response.ok) {
                    throw new Error(data.error || `Error HTTP ${response.status}`);
                }

                hideTypingIndicator();

                if (data.success) {
                    addMessage('assistant', data.reply, data.model_used, data.is_fallback);
                } else {
                    addMessage('assistant', 'Lo siento, hubo un problema. Intenta de nuevo.');
                }
            } catch (error) {
                hideTypingIndicator();
                addMessage('assistant', error.message || 'Error de conexión. Intenta de nuevo.');
                console.error('Error en sendMessage:', error);
            } finally {
                hideTypingIndicator();
                setLoading(false);
                chatInput.focus();
                startInactivityTimer();
            }
        }

        function clearChat() {
            hideTypingIndicator();
            chatMessages.querySelectorAll('[data-chat-message]').forEach((message) => message.remove());
            addMessage('assistant', welcomeMessage);
            chatInput.focus();
            startInactivityTimer();
        }

        function closeChat() {
            if (!isOpen) return;

            isOpen = false;
            chatWindow.classList.add('hidden');
            chatWindow.classList.remove('flex');
            chatToggleBtn.classList.remove('hidden');
            chatToggleBtn.setAttribute('aria-expanded', 'false');
            clearTimeout(inactivityTimer);
            hideTypingIndicator();
            endInteraction();
            chatToggleBtn.focus();
        }

        function openChat() {
            isOpen = true;
            chatWindow.classList.remove('hidden');
            chatWindow.classList.add('flex');
            chatToggleBtn.classList.add('hidden');
            chatToggleBtn.setAttribute('aria-expanded', 'true');
            chatInput.focus();
            startInteraction();
            startInactivityTimer();
        }

        chatToggleBtn.addEventListener('click', openChat);
        chatSendBtn.addEventListener('click', sendMessage);
        chatInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        });
        chatClearBtn.addEventListener('click', clearChat);
        chatCloseBtn.addEventListener('click', closeChat);
        chatSupportLink.addEventListener('click', closeChat);
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && isOpen) closeChat();
        });

        addMessage('assistant', welcomeMessage);
        window.addEventListener('beforeunload', endInteraction);
    });
</script>
