<?php

namespace App\Http\Livewire\Components\Storyline;

use Illuminate\Support\Arr;
use Livewire\Component;

class PutWhere extends Component
{
    public $storyline;
    public $classes;
    public $put_where = [];
    public $income;
    public $expense;
    public $disposable;
    public $disposable_value;
    public $constant;
    public $constant_value;

// [income.disposable:for_life, expense.disposable:for_life]
    public function mount()
    {
        $this->put_where = collect(json_decode($this->storyline->put_where) ?? [])->toArray();
        $this->income = collect(data_get($this->put_where, 'income.type'))->toArray() ?? 'disposable';
        $this->disposable_value = collect(data_get($this->put_where, 'income.value'))->toArray() ?? '';
        $this->expense = collect(data_get($this->put_where, 'expense.type'))->toArray() ?? 'disposable';
        $this->constant_value = collect(data_get($this->put_where, 'expense.value'))->toArray() ?? '';
        $this->disposable = ['for_life' => 'на жизнь', 'for_assets' => 'на активы', 'for_training' => 'на обучение'];
        $this->constant = ['active' => 'активный', 'portfolio' => 'портфельный', 'passive' => 'пасивный'];
    }

    public function updatedDisposableValue()
    {
        $value = Arr::wrap(['type' => collect($this->income)->first(), 'value' => collect($this->disposable_value)->first()]);
        data_set($this->put_where, 'income', $value);
        $this->put_where = collect($this->put_where)->toJson(JSON_PRETTY_PRINT);
        $this->storyline->update(['put_where' => $this->put_where]);
        return $this->mount();
    }
    public function updatedIncome()
    {
        $value = Arr::wrap(['type' => collect($this->income)->first(), 'value' => collect($this->disposable_value)->first()]);
        data_set($this->put_where, 'income', $value);
        $this->put_where = collect($this->put_where)->toJson(JSON_PRETTY_PRINT);
        $this->storyline->update(['put_where' => $this->put_where]);
        return $this->mount();
    }

    public function updatedExpense()
    {
        $value = Arr::wrap(['type' => collect($this->expense)->first(), 'value' => collect($this->constant_value)->first()]);
        data_set($this->put_where, 'expense', $value);
        $this->put_where = collect($this->put_where)->toJson(JSON_PRETTY_PRINT);
        $this->storyline->update(['put_where' => $this->put_where]);
        return $this->mount();
    }
    public function updatedConstantValue()
    {
        $value = Arr::wrap(['type' => collect($this->expense)->first(), 'value' => collect($this->constant_value)->first()]);
        data_set($this->put_where, 'expense', $value);
        $this->put_where = collect($this->put_where)->toJson(JSON_PRETTY_PRINT);
        $this->storyline->update(['put_where' => $this->put_where]);
        return $this->mount();
    }

    public function render()
    {
        return view('livewire.components.storyline.put-where');
    }
}
