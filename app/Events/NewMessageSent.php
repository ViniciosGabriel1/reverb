<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
class NewMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $userName;
    public $message;

    public function __construct($user_id, $userName, $message)
    {
        $this->user_id = $user_id;
        $this->userName = $userName;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        Log::info('chegou aqui com ->'.$this->user_id.$this->userName.$this->message);
        Log::info('Momento ->'. now());
        return new Channel('chat');
    }

    // public function broadcastAs()
    // {
    //     return 'NewMessageSent';
    // }
}