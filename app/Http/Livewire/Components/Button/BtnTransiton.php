<?php

namespace App\Http\Livewire\Components\Button;

use Livewire\Component;

class BtnTransiton extends Component
{
    /**
     * @var $transition обект перехода
     *
     */
    public $transition;

    public function push($type, $id)
    {
        $this->emit($type, $id);
    }

    public function copy($id)
    {
        $this->push('copy', $id);
    }

    public function delete($id)
    {
        $this->push('delete', $id);
    }

    public function add($id)
    {
        $this->push('add', $id);
    }

    public function render()
    {
        return view('livewire.components.button.btn-transiton');
    }
}
