<?php

namespace App\Http\Livewire\Components\Storyline;

use Illuminate\Support\Arr;
use Livewire\Component;

class Assets extends Component
{
    public $storyline;
    public $classes;
    public $count;
    public $currency;
    public $invested;
    public $sum;
    public $active = [];
    public $point_a = [];

    protected $listeners = ['pointA' => 'updPointA'];

    protected function rules()
    {
        return [
            'currency' => 'required',
            'count' => 'required|numeric',
            'invested' => 'required|integer',
        ];
    }

    protected $messages = [
        'currency.required' => 'Заполните',
        'count.required' => 'Ведите суму',
        'count.numeric' => 'Не число',
        'invested.required' => 'Ведите суму',
        'invested.integer' => 'Не число',
    ];

    public function mount()
    {
        $this->point_a = collect(json_decode($this->storyline->point_a))->toArray();
        $this->active = collect(data_get($this->point_a, 'active'))->toArray();
        $this->sum = collect($this->active)->sum(function ($portfolio) {
            return (integer)data_get($portfolio, 'invested');
        });
    }

    public function add()
    {
        $this->validate();
        $data = Arr::wrap(['currency' => $this->currency, 'count' => $this->count, 'invested' => $this->invested]);
        $this->active = Arr::prepend($this->active ?? [], $data);
        $this->updStr();
        $this->count = '';
        $this->invested = '';
        $this->currency = '';
        $this->emit('pointA');
    }

    public function remove($id)
    {

        $this->active = collect($this->active)->reject(function ($value, $key) use ($id) {
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
        data_set($this->point_a, 'active', $this->active);
        $point_a = collect($this->point_a)->toJson(JSON_PRETTY_PRINT);
        $this->storyline->update(['point_a' => $point_a]);
    }

    public function render()
    {
        return view('livewire.components.storyline.assets');
    }
}
