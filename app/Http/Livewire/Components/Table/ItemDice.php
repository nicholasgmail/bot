<?php

namespace App\Http\Livewire\Components\Table;

use App\Models\Cube;
use Livewire\Component;

class ItemDice extends Component
{
    public $dice;
    public $active;

    protected $listeners = ['udItems' => 'udItem'];

    public function mount()
    {
        $this->active = data_get($this->dice, 'active');
    }


    public function remove($id)
    {
        $this->emitUp('remove', $id);
    }

    public function updatedActive()
    {
       $this->dice->update(['active' => $this->active]);
    }

    public function render()
    {
        return view('livewire.components.table.item-dice');
    }
}
