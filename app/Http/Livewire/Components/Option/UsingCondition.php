<?php

namespace App\Http\Livewire\Components\Option;

use Illuminate\Support\Arr;
use Livewire\Component;

class UsingCondition extends Component
{
    public $message;
    public $involve;
    public $code;
    public $classes;

    public function mount()
    {
        $option = collect(json_decode($this->message->option->using_condition));
        if ($option->isNotEmpty()) {
            $this->involve = data_get($option, 'involve') ?? false;
            $this->code = data_get($option, 'code') ?? '';
        } else {
            $this->using_condition = false;
        }
    }

    public function addArr()
    {
        return Arr::wrap(['involve' => $this->involve, 'code' => $this->code]);
    }

    public function updated(){
        $this->message->option->update(['using_condition'=>collect($this->addArr())->toJson(JSON_PRETTY_PRINT)]);
    }

    public function render()
    {
        return view('livewire.components.option.using-condition');
    }
}
