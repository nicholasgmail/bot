<?php

namespace App\Http\Livewire\Components\Tables;

use Illuminate\Support\Arr;
use Livewire\Component;

class TableStorylines extends Component
{
    public $storylines;

    public function select($id)
    {
        $this->emit('selectStoryline', $id);
    }
    protected $listeners = ['updStorylines' => 'updatingStorylines'];

    public function updatingStorylines($mess)
    {
        $this->storylines = $mess;
    }

    public function render()
    {
        $this->storylines = array_values(Arr::sort($this->storylines, function ($value) {
            return $value['name'];
        }));
        return view('livewire.components.tables.table-storylines');
    }
}
