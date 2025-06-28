<?php

namespace App\Livewire;

use App\Events\TestingReverbEvent;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class Teste extends Component
{

    public int $count = 0;


    // #[On('echo:show12,TestingReverbEvent')]
    // public function add()
    // {
    //     Log::info('Evento recebido');

    //     $this->count++;
    // }

      public function dispatchEvents()
    {
        // foreach (range(1, 12) as $i) {
            // Dispara um evento no canal show12
            TestingReverbEvent::dispatch();

            // Log opcional para debug
            Log::info("Evento disparado");

            // Pequena pausa entre os eventos (em dev apenas)
        // }
    }

    public function render()
    {
        return view('livewire.teste');
    }
}
