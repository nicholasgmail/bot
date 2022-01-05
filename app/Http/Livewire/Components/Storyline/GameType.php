<?php

namespace App\Http\Livewire\Components\Storyline;

use Illuminate\Support\Arr;
use Livewire\Component;

class GameType extends Component
{
    public $storyline;
    public $classes;
    public $game_type;
    public $select_type = [];

    public function mount()
    {
        $this->game_type = Arr::wrap(['capital' => 'Капитал', 'passive' => 'Пассивный']);
        $this->select_type = json_decode($this->storyline->game_type);
    }

    public function updatedSelectType()
    {
        $this->storyline->update(['game_type' => collect($this->select_type)->toJson(JSON_PRETTY_PRINT)]);
        return $this->mount();
    }

    public function render()
    {
        return view('livewire.components.storyline.game-type');
    }
}
