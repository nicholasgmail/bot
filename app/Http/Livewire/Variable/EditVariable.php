<?php

namespace App\Http\Livewire\Variable;

use App\Models\Category;
use App\Models\DialogTelegram;
use App\Models\Storyline;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Variable;
use App\View\Components\Bot\Text;

class EditVariable extends Component
{

    public $variable;
    public $designation;
    public $description;
    public $open;
    public $open_test;
    public $code;
    public $upshot;
    public $category;
    public $dialog_id;

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
        $this->description = $this->variable->description;
        $this->designation = $this->variable->designation;
        $this->code = $this->variable->code;
        $this->category = Category::all();
        $dialog = DialogTelegram::all();
        $last = $dialog->last();
        $this->upshot = $last->upshot->only(['color', 'nick', 'balance', 'day_x', 'purpose', 'response_wait', 'train', 'months', 'complexity', 'level', 'list_storyline', 'months_count', 'game_count', 'purchase', 'client', 'briefcase', 'step_number', 'step_map']);
        $this->dialog_id = $last->id;

    }

    public function updateVariable()
    {
        $data = Arr::wrap(['designation' => $this->designation]);
        $validatedData = Validator::make($data, $this->rules(), $this->messages)->validate();
        $this->variable->update(['designation' => $this->designation, 'description' => $this->description, 'code' => $this->code]);
        $this->open = true;
        session()->flash('message', 'Сохранилось');
    }

    public function test()
    {
        $dialog = DialogTelegram::get();
        $this->open_test = true;
        $last = $dialog->last();
        $test = null;
        $str = new Text($this->variable, $last, $test);
        session()->flash('test', $str->render());
    }

    public function close()
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.variable.edit-variable');
    }
}
