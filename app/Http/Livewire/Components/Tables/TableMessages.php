<?php

namespace App\Http\Livewire\Components\Tables;

use Illuminate\Support\Arr;
use Livewire\Component;

class TableMessages extends Component
{
    public $messages;

    protected $listeners = ['updMessages' => 'updatingMessages'];

    public function select($id, $cls)
    {
        $this->emit('selectMessage', $id, $cls);
    }


    public function updatingMessages($mess)
    {
        $this->messages = $mess;
    }

    public function render()
    {
        $this->messages = array_values(Arr::sort($this->messages, function ($value) {
            return $value['priority'];
        }));
        return view('livewire.components.tables.table-messages');
    }
}
