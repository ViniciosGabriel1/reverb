<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Count extends Component
{

    public $count = 0;

    
    // #[On('echo:show12,TestingReverbEvent')]
    public function add()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.count');
    }
}
