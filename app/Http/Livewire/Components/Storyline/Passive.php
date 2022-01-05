<?php

namespace App\Http\Livewire\Components\Storyline;

use Illuminate\Support\Arr;
use Livewire\Component;

class Passive extends Component
{
    public $storyline;
    public $classes;
    public $percent;
    public $payment;
    public $amount;
    public $name;
    public $sum;
    public $credit = [];
    public $point_a = [];

    protected $listeners = ['pointA' => 'updPointA'];

    protected function rules()
    {
        return [
            'name' => 'required',
            'payment' => 'required|numeric',
            'amount' => 'required|numeric',
            'percent' => 'required|integer',
        ];
    }

    protected $messages = [
        'name.required' => 'Заполните',
        'amount.required' => 'Ведите платёж',
        'amount.integer' => 'Не число',
        'payment.required' => 'Ведите суму',
        'payment.integer' => 'Не число',
        'percent.required' => 'Ведите процент',
        'percent.integer' => 'Не число',
    ];

    public function mount()
    {
        $this->point_a = collect(json_decode($this->storyline->point_a))->toArray();
        $this->credit = collect(data_get($this->point_a, 'credit'))->toArray();
        /*$this->sum = collect($this->credit)->sum(function ($portfolio) {
            return (integer)data_get($portfolio, 'count');
        });*/
    }

    public function add()
    {
        $this->validate();
        $data = Arr::wrap([
            'name' => $this->name,
            'amount' => $this->amount,
            'payment' => $this->payment,
            'percent' => $this->percent
        ]);
        $this->credit = Arr::prepend($this->credit ?? [], $data);
        $this->updStr();
        $this->name = '';
        $this->amount = '';
        $this->payment = '';
        $this->percent = '';
        $this->emit('pointA');
    }

    public function remove($id)
    {

        $this->credit = collect($this->credit)->reject(function ($value, $key) use ($id) {
            return $key == $id;
        })->toArray();
        $this->updStr();
        $this->emit('pointA');
    }

    public function updPointA()
    {
        $this->point_a = collect(json_decode($this->storyline->point_a))->toArray();
    }

    public function updStr()
    {
        data_set($this->point_a, 'credit', $this->credit);
        $point_a = collect($this->point_a)->toJson(JSON_PRETTY_PRINT);
        $this->storyline->update(['point_a' => $point_a]);
    }

    public function render()
    {
        return view('livewire.components.storyline.passive');
    }
}
