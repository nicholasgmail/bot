<?php

namespace App\Http\Livewire\Image;

use App\Models\Image;
use App\Models\Pushbutton;
use App\Models\Storyline;
use App\Models\Transition;
use App\Models\Video;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditGameImage extends Component
{
    use WithFileUploads;

    /**
     * a message with a picture to edit
     *
     * @var object $image
     * @var string $type
     * @var string $caption
     * @var string $title
     * @var string $searchMessage
     * @var string $open
     */
    public $image;
    public $type;
    public $text;
    public $title;
    public $searchMessage;
    public $open;
    /**
     * attached file
     *
     * @var resource $photoFile
     */
    public $photoFile;
    /**
     * modal window opening and closing
     *
     * @var bool $isOpenEvent
     * @var bool $isOpenWhere
     */
    public $isOpenEvent = false;
    public $isOpenWhere = false;
    /**
     * an array of buttons to add to a message
     *
     * @var array $allButtons
     * @var integer $allButtons
     */
    public $allButtons;
    public $buttonPivot;
    /**
     * buttons attached to the message
     *
     * @var array $buttons
     */
    public $buttons = [];
    /**
     * @var integer $toChange
     */
    public $toChange;
    /**
     * @var string $name_transition
     * @var array $transition_model
     */
    public $name_transition;
    public $transitions = [];
    public $transition_model;
    /**
     * intermediate id table
     *
     * @var integer $pivotId
     */
    public $pivotId;
    /**
     * selecting the transition type
     * @var string $search_type ;
     */
    public $search_type = 'message';
    /**
     *
     * @var string $search
     * @var array $searchResults
     */
    public $search;
    public $searchResults = [];
    public $next;
    /**
     * опции сообщения
     * @var integer $delay
     * @var string $delay_type
     * @var integer $priority
     * @var string $button_type
     */
    public $delay;
    public $delay_type = 'seconds';
    public $priority;
    public $button_type = 'reply';

    protected function rules()
    {
        return Arr::wrap([
            'text' => "required|min:3|max:1024",
            'ph' => "file|image|mimes:jpg|max:20128",
        ]);
    }

    protected $messages = [
        'text.required' => '🖊️ поле не должно быть пустым',
        'text.min' => '🖊️ минимум 3 символа',
        'text.max' => '🖊️ не больше 64 символа',
        'ph.file' => '📷 Выберете файл в формате jpg',
        'ph.image' => '📷 Должна быть картинка jpg',
        'ph.mimes' => '📷 Картинка не в jpg формате',
        'ph.max' => '📷 Не более 20Мб'
    ];

    public function close()
    {
        $this->open = false;
    }

    public function mount()
    {
        $option = $this->image->option;
        $this->title = $this->image->title;
        $this->transition_model = $this->image->game->first()->pivot->transition_model;
        $this->priority = $this->image->option->priority;
        $this->delay = $option->delay;
        $this->delay_type = $option->delay_type;
        $this->search_type = 'message';
    }


    public function save()
    {
        $data = Arr::wrap(['title' => $this->title, 'text' => $this->transition_model, 'photo' => $this->photoFile]);
        $validatedData = Validator::make($data, $this->rules(), $this->messages)->validate();

        if (is_null($this->photoFile)) {

            $this->image->game->first()->pivot->update(['transition_model' => $this->transition_model]);

        } else {
            $ollImg = Image::where('url', $this->image->url)->count();
            if ($ollImg == 1) {
                $path = Str::replaceFirst('storage/', '/public/', $this->image->url);
                Storage::delete($path);
            }
            $url = Storage::url($this->photoFile->store('public/images/step'));
            $this->image->game->first()->pivot->update(['transition_model' => $this->transition_model]);
            $this->image->update(['url' => $url]);
        }
        $this->image->option->priority = $this->priority;
        $this->image->option->delay = $this->delay;
        $this->image->option->delay_type = $this->delay_type;
        $this->image->option->save();


        $this->image = Image::find($this->image->id);
        $this->open = true;
        session()->flash('message', 'Сохранилось');
        return false;
    }

    public function updating()
    {
        $this->image->fresh();
    }

    public function render()
    {
        return view('livewire.image.edit-game-image');
    }
}
