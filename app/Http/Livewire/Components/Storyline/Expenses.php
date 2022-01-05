<?php

namespace App\Http\Livewire\Components\Storyline;

use Illuminate\Support\Arr;
use Livewire\Component;

class Expenses extends Component
{
    public $storyline;
    public $classes;
    public $price;
    public $expense;
    public $sum;
    public $expenses = [];
    public $point_a = [];

    protected $listeners = ['pointA' => 'updPointA'];

    protected function rules()
    {
        return [
            'expense' => 'required',
            'price' => 'required|integer',
        ];
    }

    protected $messages = [
        'expense.required' => 'Заполните',
        'price.required' => 'Ведите суму',
        'price.integer' => 'Не число',
    ];

    public function mount()
    {
        $this->point_a = collect(json_decode($this->storyline->point_a))->toArray();
        $this->expenses = collect(data_get($this->point_a, 'expenses'))->toArray();
        $this->sum = collect($this->expenses)->sum(function ($portfolio) {
            return (integer)data_get($portfolio, 'price');
        });
    }

    public function add()
    {
        $this->validate();
        $data = Arr::wrap(['expense' => $this->expense, 'price' => $this->price]);
        $this->expenses = Arr::prepend($this->expenses ?? [], $data);
        $this->updStr();
        $this->price = '';
        $this->expense = '';
        $this->emit('pointA');
    }

    public function remove($id)
    {

        $this->expenses = collect($this->expenses)->reject(function ($value, $key) use ($id) {
            return $key == $id;
        })->toArray();
        $this->updStr();
        $this->emit('pointA');
    }
    public function updPointA(){
        $this->point_a = collect(json_decode($this->storyline->point_a))->toArray();
    }
    public function updStr()
    {
        data_set($this->point_a, 'expenses', $this->expenses);
        $point_a = collect($this->point_a)->toJson(JSON_PRETTY_PRINT);
        $this->storyline->update(['point_a' => $point_a]);
    }

    public function render()
    {
        return view('livewire.components.storyline.expenses');
    }
}
