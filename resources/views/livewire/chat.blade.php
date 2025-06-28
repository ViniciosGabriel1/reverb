<div class="flex flex-col h-[500px]" x-data x-on:focus-message-input.window="$refs.messageInput.focus()">
    <!-- Elemento de áudio oculto -->
    <audio id="notificationSound" src="{{ asset('sounds/message.mp3') }}" preload="auto"></audio>

    <!-- Cabeçalho do chat -->
    <div class="bg-blue-600 text-white p-4 flex justify-between items-center">
        <div>
            <h2 class="font-bold text-xl flex items-center gap-2">
                <i class="fas fa-comments"></i>
                Chat Ao Vivo
            </h2>
            <div class="text-sm opacity-90">
                <span>Online: {{ $onlineUsers }} usuários</span>
                @if($typingUsers)
                    <span class="ml-3">
                        {{ implode(', ', $typingUsers) }}
                        <span class="typing-indicator">digitando...</span>
                    </span>
                @endif
            </div>
        </div>

        <button id="soundToggle"
            wire:click="toggleSound"
            class="p-2 rounded-full hover:bg-blue-700 transition"
            title="{{ $soundEnabled ? 'Desativar notificações' : 'Ativar notificações' }}">
            <i id="soundIcon" class="fas {{ $soundEnabled ? 'fa-volume-up' : 'fa-volume-mute' }}"></i>
        </button>
    </div>

    <!-- Área de mensagens -->
    <div id="messagesContainer" class="flex-1 overflow-y-auto p-4 bg-gray-50 space-y-3">
        @if(count($messages) === 0)
            <div class="text-center text-gray-500 py-8">
                <i class="fas fa-comment-slash text-4xl mb-2"></i>
                <p>Nenhuma mensagem ainda. Seja o primeiro a enviar!</p>
            </div>
        @endif

        @foreach($messages as $index => $msg)
            @php
                $isOwnMessage = ($msg['user_id'] ?? null) === auth()->id();
                $userName = $msg['userName'] ?? 'Anônimo';
                $content = $msg['content'] ?? '';
                $timestamp = $msg['created_at'] ?? now();
                $showHeader = $index === 0 || $messages[$index-1]['user_id'] !== $msg['user_id'];
            @endphp

            <div class="message-enter">
                @if($showHeader && !$isOwnMessage)
                    <div class="flex items-center mb-1">
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold mr-2">
                            {{ substr($userName, 0, 1) }}
                        </div>
                        <span class="font-semibold text-sm">{{ $userName }}</span>
                    </div>
                @endif

                <div class="flex {{ $isOwnMessage ? 'justify-end' : 'justify-start' }}">
                    <div class="flex flex-col max-w-xs lg:max-w-md">
                        <div class="rounded-lg px-4 py-2 break-words
                            {{ $isOwnMessage 
                                ? 'bg-blue-600 text-white rounded-br-none shadow-md' 
                                : 'bg-white text-gray-900 rounded-bl-none border border-gray-200 shadow-sm' }}">
                            {{ $content }}
                        </div>
                        <span class="text-xs text-gray-500 px-2 mt-1 {{ $isOwnMessage ? 'text-right' : 'text-left' }}">
                            {{ is_string($timestamp) ? $timestamp : $timestamp->format('H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Área de input -->
    <div class="bg-gray-100 p-3 border-t border-gray-200">
        <form wire:submit.prevent="sendMessage" class="flex items-center gap-2">
            <input
                type="text"
                wire:model="message"
                wire:keydown.enter.prevent="sendMessage"
                x-ref="messageInput"
                class="flex-1 bg-white p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                placeholder="Digite sua mensagem..."
                autocomplete="off"
                wire:keydown="startTyping"
                wire:keyup.debounce.1000ms="stopTyping"
            />
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg shadow-sm transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400"
                title="Enviar mensagem"
            >
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
        <div class="text-xs text-gray-500 mt-1 flex justify-between">
            <span>Pressione Enter para enviar</span>
            @if($isTyping)
                <span class="text-blue-600">Digitando...</span>
            @endif
        </div>
    </div>
</div>
