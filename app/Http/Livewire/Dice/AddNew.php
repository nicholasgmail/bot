<?php

namespace App\Http\Livewire\Dice;

use App\Models\{Cube};
use Illuminate\Support\Arr;
use Livewire\Component;

class AddNew extends Component
{
    public $allDice;
    public $title;

    protected $listeners = ['remove' => 'removeItem'];

    protected function rules()
    {
        return Arr::wrap([
            'title' => "required|min:3|max:64"
        ]);
    }

    protected $messages = [
        'title.required' => '🖊️ постарайся и пойдем дальше',
        'title.min' => '🖊️ минимум 3 символа',
        'title.max' => '🖊️ не больше 64 символа должно быть',
    ];

    public function mount()
    {
        $this->allDice = Cube::get();
    }

    public function save()
    {
        $this->validate();
        Cube::create(['title' => $this->title]);
        $this->title = '';
        session()->flash('message', 'Сохранено');
        return $this->updating();
    }

    public function removeItem($id)
    {
        $cube = Cube::where('id', $id)->delete();
        session()->flash('message', 'Удалено');
        return $this->updating();
    }

    public function updating()
    {
        $this->allDice->fresh();
        return $this->mount();
    }

    public function update()
    {

    }

    public function render()
    {
        return view('livewire.dice.add-new');
    }
}
