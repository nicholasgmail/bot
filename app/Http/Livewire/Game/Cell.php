<?php

namespace App\Http\Livewire\Game;

use App\Models\Game;
use App\Models\Image;
use App\Models\Option;
use Composer\DependencyResolver\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Component;

class Cell extends Component
{
    use WithFileUploads;

    public $cell;
    public $open = false;
    public $tab = 'white';
    public $option;
    public $photoFile;
    public $сolors;
    public $game;
    public $delay = 0;
    public $delay_type = 'seconds';
    public $transition_model;
    public $transition_images;
    public $notify = 'Сохранил';

    //protected $listeners = ['refreshChildren' => 'save'];

    protected function rules()
    {
        return Arr::wrap([
             'text' => "required|min:3|max:64",
             'photoFile' => "required|file|image|mimes:jpg|max:20128",
        ]);
    }

    protected $messages = [
        'text.required' => '🖊️ поле не должно быть пустым',
        'text.min' => '🖊️ минимум 3 символа',
        'text.max' => '🖊️ не больше 64 символа',
        'photoFile.required' => '📷 Выберете файл в формате jpg',
        'photoFile.file' => '📷 Выберете файл в формате jpg',
        'photoFile.image' => '📷 Должна быть картинка jpg',
        'photoFile.mimes' => '📷 Картинка не в jpg формате',
        'photoFile.max' => '📷 Не более 20Мб'
    ];

    /**
     * adding options
     *
     * @return Option
     */
    public function optionAdd()
    {
        return new Option(['figure' => $this->option, 'delay' => $this->delay, 'delay_type' => $this->delay_type]);
    }

    public function upList()
    {
        $image = $this->game->images()->wherePivot('cell', $this->cell)->get();
        $this->transition_images = $image->map(function ($item) {
            $image = Image::find($item->id);
            return collect($item)->merge([
                'figure' => $image->option->figure,
                'delay' => $image->option->delay,
                'delay_type' => $image->option->delay_type
            ]);
        });
    }

    public function mount()
    {
        $this->upList();
        $this->сolors = Arr::wrap(['white' => "белый", 'black' => 'чёрный', "violet" => 'фиолетовый', "turquoise" => 'бирюзовый']);
        $this->option = "white";
    }

    public function updating()
    {
        $this->game = $this->game->fresh();
    }

    public function close()
    {
        $this->open = !$this->open;
    }

    public function remove($id)
    {
        $img = Image::findOrFail($id);
        $img->game()->detach();
        $img->option()->delete();
        $path = Str::replaceFirst('storage/', '/public/', $img->url);
        Storage::delete($path);
        $img->delete();
        return $this->mount();
    }

    public function save()
    {
        $data = Arr::wrap(['text' => $this->transition_model, 'photoFile'=>$this->photoFile]);
        $validatedData = Validator::make($data, $this->rules(), $this->messages)->validate();

        $url = Storage::url($this->photoFile->store('public/images/transition/' . $this->cell . '/' . $this->option));
        $image = new Image(['url' => $url]);
        $img = $this->game->images()->save($image);
        $option = $this->optionAdd();
        $img->option()->save($option);
        $img->game()->sync([1 => ['transition_model' => $this->transition_model, 'cell' => $this->cell]]);
        $this->transition_model = null;
        $this->photoFile = null;
        $this->open = true;

        session()->flash('message', 'Сохранилось');
        $this->game = $this->game->fresh();
        return $this->mount();
    }


    public function render()
    {
        return view('livewire.game.cell');
    }
}
