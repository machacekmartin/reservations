<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class InteractiveCanvas extends Component
{
    public function render(): View
    {
        return view('livewire.interactive-canvas');
    }
}
