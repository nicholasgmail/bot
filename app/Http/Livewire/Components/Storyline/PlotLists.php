<?php

namespace App\Http\Livewire\Components\Storyline;

use Illuminate\Support\Arr;
use Livewire\Component;

class PlotLists extends Component
{
    public $storyline;
    public $classes;
    public $exclude;
    public $show;
    public $name;
    public $from_what;
    public $up_to_what;

    public function mount()
    {
        $arr = json_decode($this->storyline->plot_lists);
        $this->exclude = data_get($arr, 'exclude');
        $this->show = data_get($arr, 'show');
        $this->name = data_get($arr, 'name');
        $this->from_what = data_get($arr, 'from_what');
        $this->up_to_what = data_get($arr, 'up_to_what');
    }

    public function updated()
    {
        $this->plot_lists = Arr::wrap(['exclude' => $this->exclude, 'show' => $this->show, 'name' => $this->name, 'from_what' => $this->from_what, 'up_to_what' => $this->up_to_what]);
        $this->storyline->update(['plot_lists' => collect($this->plot_lists)->toJson(JSON_PRETTY_PRINT)]);
        return $this->mount();
    }

    public function render()
    {
        return view('livewire.components.storyline.plot-lists');
    }
}
