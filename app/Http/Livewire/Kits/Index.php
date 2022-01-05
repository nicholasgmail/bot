<?php

namespace App\Http\Livewire\Kits;

use Livewire\Component;
use App\Models\Kits;

class Index extends Component
{
    public $kits;

    public function mount(){
        $this->kits = Kits::all();
    }

    public function render()
    {
        return view('livewire.kits.index');
    }
}
