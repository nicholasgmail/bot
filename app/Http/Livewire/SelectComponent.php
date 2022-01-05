<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectComponent extends Component
{
    public $name = 'jelly';

    public function render()
    {
        return view('livewire.select-component');
    }
}
