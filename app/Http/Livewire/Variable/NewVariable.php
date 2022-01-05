<?php

namespace App\Http\Livewire\Variable;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Variable;

class NewVariable extends Component
{
    public $list;
    public $designation;
    public $description;
    public $search;

    protected function rules()
    {
        return Arr::wrap([
            'designation' => 'required|min:3|max:64',
        ]);
    }

    protected $messages = [
        'designation.required' => '🖊️ поле не должно быть пустым',
        'designation.min' => '🖊️ минимум 3 символа',
        'designation.max' => '🖊️ 64 символа',
    ];

    public function mount()
    {
        $this->list = Variable::get();
    }

    public function add()
    {
        $data = Arr::wrap(['designation' => $this->designation]);
        $validatedData = Validator::make($data, $this->rules(), $this->messages)->validate();
        Variable::create(['designation' => $this->designation, 'description' => $this->description]);
        $this->designation = '';
        $this->description = '';
        return $this->mount();
    }

    public function remove(Variable $variable)
    {
        $variable->delete();
        return $this->mount();
    }

    public function updatedSearch()
    {
        $srh = Str::of($this->search)->lower();
        if (Str::length($this->search) > 1) {
            $this->list = $this->list->filter(function ($value, $key) use ($srh) {
                return Str::of(data_get($value, 'designation'))->lower()->contains($srh);
            });
        } else {
            $this->list = Variable::get();
        }

    }

    public function render()
    {
        return view('livewire.variable.new-variable');
    }
}
