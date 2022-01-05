<?php

namespace App\Http\Livewire\Components\Variable;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;

class PointA extends Component
{
    public $categorye;
    public $category;
    public $loan;
    public $credit;
    public $active;
    public $expenses;
    public $clients;
    public $balance_a;

    public function mount()
    {
        $this->category = $this->categorye->first(function ($v, $k) {
            return Str::of(data_get($v, 'name'))->lower()->is('*точка а*');
        });
        $point_a = collect(json_decode($this->category->storyline->first()->point_a))->toArray();
        $this->loan = collect(Arr::first(data_get($point_a, 'loan')))->toArray();
        $this->credit = collect(Arr::first(data_get($point_a, 'credit')))->toArray();
        $this->active = collect(Arr::first(data_get($point_a, 'active')))->toArray();
        $this->expenses = collect(Arr::first(data_get($point_a, 'expenses')))->toArray();
        $this->clients = collect(Arr::first(data_get($point_a, 'clients')))->toArray();
        $this->balance_a = data_get($point_a, 'balance_a');
    }

    public function render()
    {
        return view('livewire.components.variable.point-a');
    }
}
