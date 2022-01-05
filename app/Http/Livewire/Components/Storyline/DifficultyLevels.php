<?php

namespace App\Http\Livewire\Components\Storyline;

use Illuminate\Support\Arr;
use Livewire\Component;

class DifficultyLevels extends Component
{
    public $storyline;
    public $classes;
    public $difficulty_levels;
    public $select_levels = [];
    public $balance_levels = [];
    public $lv_1;
    public $lv_2;
    public $lv_3;
    public $lv_4;
    public $lv_5;
    public $lv_6;
    public $lv_7;

    public function mount()
    {
        $this->difficulty_levels = Arr::wrap(['lv_1' => 'Уровень 1', 'lv_2' => 'Уровень 2', 'lv_3' => 'Уровень 3', 'lv_4' => 'Уровень 4', 'lv_5' => 'Уровень 5', 'lv_6' => 'Уровень 6', 'lv_7' => 'Уровень 7']);
        $this->select_levels = collect(json_decode($this->storyline->level))->toArray();
        $this->balance_levels = collect(json_decode($this->storyline->balance))->toArray();
        $this->lv_1 = data_get($this->balance_levels, 'lv_1');
        $this->lv_2 = data_get($this->balance_levels, 'lv_2');
        $this->lv_3 = data_get($this->balance_levels, 'lv_3');
        $this->lv_4 = data_get($this->balance_levels, 'lv_4');
        $this->lv_5 = data_get($this->balance_levels, 'lv_5');
        $this->lv_6 = data_get($this->balance_levels, 'lv_6');
        $this->lv_7 = data_get($this->balance_levels, 'lv_7');
    }

    /*public function updatedSelectLevels()
    {
        $this->storyline->update(['level' => collect($this->select_levels)->toJson(JSON_PRETTY_PRINT)]);
        return $this->mount();
    }*/

    public function updated()
    {
        $this->storyline->update(['level' => collect($this->select_levels)->toJson(JSON_PRETTY_PRINT)]);
        $this->balance_levels = Arr::wrap(['lv_1' => $this->lv_1, 'lv_2' => $this->lv_2, 'lv_3' => $this->lv_3, 'lv_4' => $this->lv_4, 'lv_5' => $this->lv_5, 'lv_6' => $this->lv_6, 'lv_7' => $this->lv_7]);
        $this->storyline->update(['balance' => collect($this->balance_levels)->toJson(JSON_PRETTY_PRINT)]);
        return $this->mount();
    }

    public function render()
    {
        return view('livewire.components.storyline.difficulty-levels');
    }
}
