<?php

namespace App\Http\Livewire\Game;

use App\Models\Step;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;


class NewCustomizing extends Component
{
    use WithFileUploads;

    public $text;
    public $name;
    public $raid;
    public $first_train;
    public $battle;
    //  public $salute;
    public $regular_train;
    public $field_size;
    public $idGame;
    public $game;
    public $open = false;
    public $editId;
    public $isOpenCell = false;
    public $cell = 0;


    protected function rules()
    {
        return Arr::wrap([
            'name' => 'required|min:3|max:64',
            'first_train' => 'required|min:3|max:64',
            'regular_train' => 'required|min:3max:64',
            'raid' => 'required|min:3max:64',
            'battle' => 'required|min:3max:64',
            'salute' => 'required|min:3max:1024',
        ]);
    }

    protected $messages = [
        'name.required' => '🖊️ поле не должно быть пустым',
        'name.min' => '🖊️ минимум 3 символа',
        'name.max' => '🖊️ 64 символа',
        'first_train.required' => '🖊️ поле не должно быть пустым',
        'first_train.min' => '🖊️ минимум 3 символа',
        'first_train.max' => '🖊️ 64 символа',
        'regular_train.required' => '🖊️ поле не должно быть пустым',
        'regular_train.min' => '🖊️ минимум 3 символа',
        'regular_train.max' => '🖊️ 64 символа',
        'raid.required' => '🖊️ поле не должно быть пустым',
        'raid.min' => '🖊️ минимум 3 символа',
        'raid.max' => '🖊️ 64 символа',
        'battle.required' => '🖊️ поле не должно быть пустым',
        'battle.min' => '🖊️ минимум 3 символа',
        'battle.max' => '🖊️ 64 символа',
        'salute.required' => '🖊️ поле не должно быть пустым',
        'salute.min' => '🖊️ минимум 3 символа',
        'salute.max' => '🖊️ 1024 символа',
    ];

    public function alert($text = 'Сохранилось')
    {
        $this->open = $this->open();
        session()->flash('message', $text);
        return true;
    }

    public function close()
    {
        $this->open = false;
    }

    public function openCell($cell)
    {
        $this->cell = $cell;
        $this->open = true;
        return true;
    }

    /**
     * TODO сделать сервис валидации
     */
    public function saveGame()
    {
        $data = Arr::wrap(['name' => $this->name,
            'first_train' => $this->first_train,
            'regular_train' => $this->regular_train,
            'raid' => $this->raid,
            'battle' => $this->battle]);
        $validatedData = Validator::make($data, $this->rules(), $this->messages)->validate();
        $this->game->update([
            'name' => $this->name,
            'first_train' => $this->first_train,
            'regular_train' => $this->regular_train,
            'raid' => $this->raid,
            'battle' => $this->battle,
            'field_size' => (integer)$this->field_size]);
        $this->open = true;
        session()->flash('message', 'Сохранилось');
        return true;
    }

    /**
     * getting a set of messages && videos && images
     */
    public function mount()
    {
        $this->first_train = data_get($this->game, 'first_train');
        $this->regular_train = data_get($this->game, 'regular_train');
        $this->raid = data_get($this->game, 'raid');
        $this->battle = data_get($this->game, 'battle');
        $this->name = data_get($this->game, 'name');
        // $this->salute = data_get($this->game, 'salute');
        $this->field_size = data_get($this->game, 'field_size');
    }

    /**
     * @param $game
     */
    public function updating()
    {
        $this->game->fresh();
    }

    public function render()
    {
        return view('livewire.game.new-customizing');
    }
}
