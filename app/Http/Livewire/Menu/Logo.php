<?php

namespace App\Http\Livewire\Menu;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Logo extends Component
{
   public $path;

    public function render()
    {
        $this->path = Storage::url('images/totx-logo-header.png');

        return <<<'blade'
            <div>
               <image src="{{$path}}" class="block h-9 w-auto" alt="">
            </div>
        blade;
    }
}
