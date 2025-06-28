<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
    <meta name="user-id" content="{{ auth()->id() }}">
    @endauth
    <title>Chat Livewire12</title>
    <link rel="preload" href="{{ asset('sounds/notification.mp3') }}" as="audio" type="audio/mpeg">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>

<body class="bg-gray-100">
    <div class="container mx-auto max-w-4xl p-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            
            @livewire('chat')
            {{-- @livewire('teste') --}}
        </div>
    </div>

    @vite('resources/js/app.js')
    @livewireScripts
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const notificationSound = new Audio("{{ asset('sounds/xavinho.mpeg') }}");
        notificationSound.load();

        window.addEventListener('play-notification-sound', () => {
            notificationSound.play().catch(e => {
                console.error('Erro ao reproduzir som:', e);
            });
        });
    });
</script>


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuração do som
            const notificationSound = new Audio("{{ asset('sounds/message.mp3') }}");
            notificationSound.volume = 0.5;
            
            // Verifica preferência do usuário
            let soundEnabled = localStorage.getItem('soundEnabled') !== 'false';
            
            // Elementos DOM
            const messagesContainer = document.getElementById('messagesContainer');
            const soundToggleBtn = document.getElementById('soundToggle');
            const soundIcon = document.getElementById('soundIcon');
            
            // Função para alternar som
            function toggleSound() {
                soundEnabled = !soundEnabled;
                localStorage.setItem('soundEnabled', soundEnabled);
                updateSoundIcon();
            }
            
            // Atualiza ícone do som
            function updateSoundIcon() {
                if (soundIcon) {
                    soundIcon.className = soundEnabled ? 'fas fa-volume-up' : 'fas fa-volume-mute';
                }
            }
            
            // Scroll automático
            function scrollToBottom() {
                messagesContainer.scrollTo({
                    top: messagesContainer.scrollHeight,
                    behavior: 'smooth'
                });
            }
            
            // Event listeners
            if (soundToggleBtn) {
                soundToggleBtn.addEventListener('click', toggleSound);
            }
            
            // Ouvinte de eventos Livewire
            window.addEventListener('new-message-notification', function() {
                if (soundEnabled) {
                    notificationSound.play().catch(e => {
                        console.error("Erro ao reproduzir som:", e);
                    });
                }
            });
            
            Livewire.hook('message.processed', () => {
                const isNearBottom = messagesContainer.scrollHeight - messagesContainer.clientHeight <= messagesContainer.scrollTop + 100;
                if (isNearBottom) {
                    scrollToBottom();
                }
            });
            
            // Inicialização
            updateSoundIcon();
            scrollToBottom();
        });
    </script> --}}
</body>

</html>