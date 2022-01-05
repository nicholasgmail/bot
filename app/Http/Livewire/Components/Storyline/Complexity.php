<?php

namespace App\Http\Livewire\Components\Storyline;

use Illuminate\Support\Arr;
use Livewire\Component;

class Complexity extends Component
{
    public $storyline;
    public $classes;
    public $complexity;
    public $selectcomplexity = [];

    public function mount()
    {
        $this->complexity = Arr::wrap(['light' => 'Лайт', 'normal' => 'Норм', 'hard' => 'Хард']);
        $this->selectcomplexity = json_decode($this->storyline->complexity);
    }

    public function updatedSelectcomplexity()
    {
        $this->storyline->update(['complexity' => collect($this->selectcomplexity)->toJson(JSON_PRETTY_PRINT)]);
        return $this->mount();
    }

    public function render()
    {
        return view('livewire.components.storyline.complexity');
    }
}
