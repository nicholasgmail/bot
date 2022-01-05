<?php

namespace App\Http\Livewire\Components\Storyline;

use Illuminate\Support\Arr;
use Livewire\Component;

class BalanceA extends Component
{
    public $storyline;
    public $classes;
    public $balance;
    public $point_a;

    protected $listeners = ['pointA' => 'updPointA'];

    protected function rules()
    {
        return [
            'balance' => 'required|integer',
        ];
    }

    protected $messages = [
        'balance.required' => 'Ведите суму',
        'balance.integer' => 'Не число',
    ];

    public function mount()
    {
        $this->point_a = collect(json_decode($this->storyline->point_a))->toArray();
        $this->balance = (integer)data_get($this->point_a, 'balance_a') ?? 0;
    }

   /* public function add()
    {
        $this->validate();
        $data = Arr::wrap(['balance' => sprintf('%s', $this->client)]);
        $this->point_a = Arr::prepend($this->point_a ?? [], $data);
        $this->updatedStoryline();
        return $this->mount();
    }*/
    public function updPointA()
    {
        $this->point_a = collect(json_decode($this->storyline->point_a))->toArray();
    }
    public function updatedBalance()
    {
        $this->validate();
        data_set($this->point_a, 'balance_a', $this->balance);
        $point_a = collect($this->point_a)->toJson(JSON_PRETTY_PRINT);
        $this->storyline->update(['point_a' => $point_a]);
        $this->emit('pointA');
    }
    public function render()
    {
        return view('livewire.components.storyline.balance-a');
    }
}
