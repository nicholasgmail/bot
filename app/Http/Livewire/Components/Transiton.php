<?php

namespace App\Http\Livewire\Components;

use App\Models\Transition;
use App\Traits\MessageCollect;
use Livewire\Component;

class Transiton extends Component
{
    use MessageCollect;

    public $transition;

    public function mount(){
        $transition = $this->getMessage(class_basename($this->transition->storylinegable_type), $this->transition->storylinegable_id);
        if(is_null($transition)){
            $this->transition->update(['storylinegable_type'=>null, 'storylinegable_id'=>null]);
        }
    }

    public function render()
    {
        return view('livewire.components.transiton');
    }
}
