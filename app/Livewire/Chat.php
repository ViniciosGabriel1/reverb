<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Events\NewMessageSent;
use Illuminate\Support\Facades\Log;

class Chat extends Component
{
    public $messages = [];
    public $message = '';
    public $onlineUsers = 0;
    public $isTyping = false;
    public $typingUsers = [];
    public $soundEnabled = true;

    public function mount()
    {
        // Valor padrão para soundEnabled
        $this->soundEnabled = true;
    }

    public function sendMessage()
    {
        // dd($this->all());
        $this->validate(['message' => 'required|string|max:500']);

        event(new NewMessageSent(
            auth()->id(),
            auth()->user()->name,
            $this->message
        ));

        $this->message = '';
        $this->isTyping = false;
    }

    #[On('echo:chat,NewMessageSent')]
    public function receiveMessage($payload)
    {

        Log::info('Evento recebido no Livewire', $payload);
        if ($payload['user_id'] != auth()->id()) {
            $this->dispatch('new-message-notification');
        }

        $this->messages[] = [
            'user_id' => $payload['user_id'],
            'userName' => $payload['userName'],
            'content' => $payload['message'],
            'created_at' => now()
        ];

        if ($payload['user_id'] != auth()->id()) {
            $this->dispatch('play-notification-sound'); // toca só para os outros
        }
    }

    public function startTyping()
    {
        $this->isTyping = true;
        // Lógica para notificar outros usuários
    }

    public function stopTyping()
    {
        $this->isTyping = false;
        // Lógica para notificar outros usuários
    }

    public function toggleSound()
    {
        $this->soundEnabled = !$this->soundEnabled;
        $this->dispatchBrowserEvent('sound-toggled', ['enabled' => $this->soundEnabled]);
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
