<?php

namespace App\Http\Livewire\Components\Tables;

use Illuminate\Support\Arr;
use Livewire\Component;

class TableMessagesCopy extends Component
{
    public $messages;

    protected $listeners = ['updMessages' => 'updatingMessages'];

    public function copy()
    {
        $this->emit('copyItem');
    }

    public function updatingMessages($mess)
    {
        $this->messages = $mess;
    }

    public function render()
    {
        $this->messages = array_values(Arr::sort($this->messages, function ($value) {
            return data_get($value, 'option.priority');
        }));
        return view('livewire.components.tables.table-messages-copy');
    }
}
