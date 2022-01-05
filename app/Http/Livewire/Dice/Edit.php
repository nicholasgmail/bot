<?php

namespace App\Http\Livewire\Dice;

use App\Models\Image;
use App\Models\Option;
use App\Traits\MessageCollect;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Edit extends Component
{
    use WithFileUploads, MessageCollect;

    public $dice;
    public $caption;
    public $title;
    public $priority = 1;
    public $delay_type = 'seconds';
    public $delay = 0;
    public $photoFile;
    public $allDice;


    /**
     * adding options
     *
     * @return Option
     */
    public function optionAdd()
    {
        return new Option(['priority' => $this->priority, 'delay' => $this->delay, 'delay_type' => $this->delay_type]);
    }

    /**
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addDice()
    {
        $validatedData = Validator::make(
            ['title' => $this->title],
            ['title' => "required|min:1|max:64"],
            ['required' => '🖊️ постарайся и пойдем дальше',
                'min' => '🖊️ минимум 1 символа',
                'max' => '🖊️ не больше 64 символа должно быть']
        )->validate();
        $validatedData = Validator::make(
            ['text' => $this->caption],
            ['text' => "required|min:3|max:1024"],
            ['required' => '🖊️ поле должно быть заполнено',
                'min' => '🖊️ минимум 3 символа',
                'max' => '🖊️ не больше 1024 символа должно быть']
        )->validate();

        $validatedData = Validator::make(
            ['photoFile' => $this->photoFile],
            ['photoFile' => "required|file|image|mimes:png|max:10048"],
            ['required' => '📷 Выберете файл',
                'file' => '📷 Выберете файл в формате png',
                'image' => '📷 Должна быть картинка png',
                'mimes' => '📷 Картинка не в png формате',
                'max' => '📷 Не более 10Мб'],
        )->validate();

        $url = Storage::url($this->photoFile->store('public/images/dice'));
        $image = new Image(['title' => $this->title, 'url' => $url, 'caption' => $this->caption]);
        $option = $this->optionAdd();
        $mage = $this->dice->images()->save($image);
        $mage->option()->save($option);

        $this->title = '';
        $this->caption = '';
        $this->photoFile = '';
        return $this->mount();
    }

    /**
     * getting a set of messages && videos && images
     */
    public function mount()
    {
        $this->allDice = $this->dice->images;
    }

    public function removeMessage($id)
    {
        $item = $this->allDice->where('id', $id);
        $image = $item->first();
        $path = Str::replaceFirst('storage/', '/public/', $image->url);
        $ollImg = Image::where('url', $image->url)->count();
        if ($ollImg == 1) {
        Storage::delete($path);
        }
        $image->cube()->detach();
        $image->option()->delete();
        $image->delete();
        return $this->mount();
    }

    public function updating()
    {
        $this->dice->fresh();
    }

 /*   public function updatedDice()
    {
        $this->dice = $this->dice->fresh();
    }*/

    public function updated($allDice)
    {

        $this->allDice = $this->dice->images;
    }


    public function render()
    {
        return view('livewire.dice.edit');
    }
}
