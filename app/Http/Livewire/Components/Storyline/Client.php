<?php

namespace App\Http\Livewire\Components\Storyline;

use Illuminate\Support\Arr;
use Livewire\Component;

class Client extends Component
{
    public $storyline;
    public $classes;
    public $client;
    public $sum;
    public $profit;
    public $portfolio = [];
    public $point_a = [];

    protected $listeners = ['pointA' => 'updPointA'];

    protected function rules()
    {
        return [
            'client' => 'required',
            'profit' => 'required|integer',
        ];
    }

    protected $messages = [
        'client.required' => 'Заполните',
        'profit.required' => 'Ведите суму',
        'profit.integer' => 'Не число',
    ];

    public function mount()
    {
        $this->point_a = collect(json_decode($this->storyline->point_a))->toArray();
        $this->portfolio = collect(data_get($this->point_a, 'clients'))->toArray();
        $this->sum = collect($this->portfolio)->sum(function ($portfolio) {
            return (integer)data_get($portfolio, 'profit');
        });
    }

    public function add()
    {
        $this->validate();
        $data = Arr::wrap(['client' => $this->client, 'profit' => $this->profit]);
        $this->portfolio = Arr::prepend($this->portfolio ?? [], $data);
        $this->updStr();
        $this->emit('pointA');
    }

    public function remove($id)
    {
        $filtered = collect($this->portfolio)->reject(function ($value, $key) use ($id) {
            return $key == $id;
        });
        $this->portfolio = $filtered->toArray();
        $this->updStr();
        $this->emit('pointA');
    }
    public function updPointA(){
        $this->point_a = collect(json_decode($this->storyline->point_a))->toArray();
    }
    public function updStr()
    {
        data_set($this->point_a, 'clients', $this->portfolio);
        $point_a = collect($this->point_a)->toJson(JSON_PRETTY_PRINT);
        $this->storyline->update(['point_a' => $point_a]);
        $this->client = '';
        $this->profit = '';
    }

    public function render()
    {
        return view('livewire.components.storyline.client');
    }
}
