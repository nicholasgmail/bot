<?php

namespace App\Http\Livewire\Components\Form;

use Livewire\Component;

class EditTransition extends Component
{
    /**
     * @var $transition обект перехода
     * @var $name имя перехода
     * @var $weigth вес перехода
     * @var $btn_random кнопка рандомная или нет
     */
    public $transition;
    public $name;
    public $weight;
    public $btn_random;

    public function mount()
    {
        $this->name = data_get($this->transition, 'name');
        $this->weight = data_get($this->transition, 'weight');
        $this->btn_random = data_get($this->transition, 'btn_random');
    }

    public function updatedWeight()
    {
        $this->transition->update(['weight' => $this->weight]);

    }

    public function updatedBtnRandom()
    {
        $this->transition->update(['btn_random' => $this->btn_random]);
    }

    public function updatedName()
    {
        $this->transition->update(['name' => $this->name]);
    }

    public function render()
    {
        return view('livewire.components.form.edit-transition');
    }
}
