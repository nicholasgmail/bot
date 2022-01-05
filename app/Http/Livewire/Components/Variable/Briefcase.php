<?php

namespace App\Http\Livewire\Components\Variable;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;

class Briefcase extends Component
{
    public $upshot;
    public $category;
    public $loan;
    public $credit;
    public $active;
    public $expenses;
    public $clients;
    public $balance_a;

    public function mount()
    {
        $briefcase = collect(json_decode(data_get($this->upshot, 'briefcase')))->toArray();
        $this->loan = collect(Arr::first(data_get($briefcase, 'loan')))->toArray();
        $this->credit = collect(Arr::first(data_get($briefcase, 'credit')))->toArray();
        $this->active = collect(Arr::first(data_get($briefcase, 'active')))->toArray();
        $this->expenses = collect(Arr::first(data_get($briefcase, 'expenses')))->toArray();
        $this->clients = collect(Arr::first(data_get($briefcase, 'clients')))->toArray();
        $this->balance_a = data_get($briefcase, 'balance_a');
    }
    public function render()
    {
        return view('livewire.components.variable.briefcase');
    }
}
