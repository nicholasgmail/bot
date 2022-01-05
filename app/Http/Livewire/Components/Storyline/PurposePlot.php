<?php

namespace App\Http\Livewire\Components\Storyline;

use Livewire\Component;

class PurposePlot extends Component
{
    public $storyline;
    public $classes;
    public $purpose_plot;

    public function mount(){
        $this->purpose_plot = $this->storyline->purpose_plot;
    }
    public function updatedPurposePlot(){
        $this->storyline->update(['purpose_plot' => $this->purpose_plot]);
    }
    public function render()
    {
        return view('livewire.components.storyline.purpose-plot');
    }
}
