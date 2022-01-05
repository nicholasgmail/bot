<?php

namespace App\Http\Livewire\Step;

use App\Models\Image;
use App\Models\Message;
use App\Models\Option;
use App\Models\Storyline;
use App\Models\Step;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewCustomizing extends Component
{
    use WithFileUploads;

    public $text;
    public $title;
    public $priority = 1;
    public $delay_type = 'seconds';
    public $delay = 3;
    public $idStep;
    public $step;
    public $confirmingUserDeletion;
   /* public $option = "black";
    public $photoFile;*/
    public $allButtons;
    public $buttons = [];
    public $editId;
    public $isOpenStoryline = false;
    public $allMessages;
    public $allStoryline;
    public $storyline = [];
    public $detach = [];


    public function close()
    {
        $this->confirmingUserDeletion = false;
    }

    public function edit()
    {
        $this->confirmingUserDeletion = false;
    }

    /**
     * adding options
     *
     * @return Option
     */
    public function optionAdd()
    {
        return new Option(['figure' => $this->option, 'delay' => $this->delay, 'delay_type' => $this->delay_type]);
    }

    /**
     *
     * a collection consisting of messages && images && video
     *
     * @param integer $id
     * @return \Illuminate\Support\Collection
     */
    public function collectStep($id)
    {
        $all_collection = collect();
        $step = Step::find($id);
        $collection_images = $step->images;

        if ($collection_images->isNotEmpty()) {
            $imag = $collection_images->map(function ($item) {
                $image = Image::find($item->id);
                return collect($item)->merge([
                    'figure' => $image->option->first()->figure,
                    'delay' => $image->option->first()->delay,
                    'delay_type' => $image->option->first()->delay_type
                ]);
            });
            if ($imag->isNotEmpty()) {
                $all_collection = $all_collection->merge($imag);
            }
        }

        return $all_collection;
    }

    /**
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addContent()
    {
        $validatedData = Validator::make(
            ['text' => $this->text],
            ['text' => "required|min:3|max:1024"],
            ['required' => '🖊️ постарайся и пойдем дальше',
                'min' => '🖊️ еще не много и можно сохранится, минимум 3 символа',
                'max' => '🖊️ ого лихо многовато текста, 1024 символа должно быть']
        )->validate();
        $validatedData = Validator::make(
            ['text' => $this->title],
            ['text' => "required|min:3|max:64"],
            ['required' => '🖊️ постарайся и пойдем дальше',
                'min' => '🖊️ еще не много и можно сохранится, минимум 3 символа',
                'max' => '🖊️ ого лихо многовато текста, 1024 символа должно быть']
        )->validate();
        $validatedData = Validator::make(
            ['photoFile' => $this->photoFile],
            ['photoFile' => "required|file|image|mimes:jpg|max:2048"],
            ['required' => '📷 Выберете файл',
                'file' => '📷 Выберете файл в формате jpg',
                'image' => '📷 Должна быть картинка jpg',
                'mimes' => '📷 Картинка не в jpg формате',
                'max' => '📷 Не более 2Мб'],
        )->validate();

        $url = Storage::url($this->photoFile->store('public/images/step'));
        $image = new Image(['title' => $this->title, 'url' => $url, 'caption' => $this->text]);
        $option = $this->optionAdd();
        $step = Step::findOrNew($this->idStep);
        $mage = $step->images()->save($image);
        $mage->option()->save($option);
        $this->text = '';
        $this->title = '';
        $this->photoFile = '';
        $this->allMessages = $this->collectStep($this->idStep);
    }

    /**
     * getting a set of messages && videos && images
     */
    public function mount()
    {
        $this->allMessages = $this->collectStep($this->idStep);
        $this->allStoryline = Storyline::all();
        $this->detach = [];
        $this->storyline = [];
    }

    public function removeMessage($key)
    {
        $item = $this->allMessages[$key];
        $image = Image::find(data_get($item, 'id'));
        $image->step()->detach();
        $image->option()->delete();
        $image->delete();
        $this->allMessages = $this->collectStep($this->idStep);
    }

    public function openPushbutton($id)
    {
        $this->confirmingUserDeletion = true;
        $this->editId = $id;

    }

    public function addStoryline(){
        $storyline = Storyline::whereIn('id', $this->storyline)->get();
        $this->step->storyline()->attach($storyline);
        $this->step = Step::find($this->step->id);
        return $this->isOpenStoryline=false;
    }

    public function detachStoryline(){
        $detachStep = $this->step->storyline()->wherePivotIn('id', $this->detach);
        $this->step = Step::find($this->step->id);
        return $detachStep->detach();
    }

    /**
     * @param collection $allMessages
     */
    public function updated($allMessages, $step)
    {
        /**
         * updating a set of messages
         */
        $this->allMessages = $this->collectStep($this->idStep);
    }

    public function render()
    {
        return view('livewire.step.new-customizing');
    }
}
