<?php

namespace App\Http\Livewire\Components\Form;

use Livewire\Component;

class Radio extends Component
{
    /**
     * @var string $option ;
     * @var string $value ;
     * @var string $context ;
     */
    public $option;
    public $value;
    public $context;

    public $listeners=['selectRadio'=>'newContext'];

    public function variant()
    {
        $this->emit('radio', $this->value);
    }
    public function newContext($ctx){
        return $this->context = $ctx;

    }
    /*public function updating()
    {
        $this->context;
    }*/

    public function render()
    {
        return view('livewire.components.form.radio');
    }
}
