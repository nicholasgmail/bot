<?php

namespace App\Http\Livewire\Video;

use App\Models\Video;
use App\Models\Storyline;
use App\Models\Transition;
use App\Traits\MessageCollect;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditVideo extends Component
{
    use WithFileUploads, MessageCollect;

    /**
     * a message with a picture to edit
     *
     * @var object $video
     */
    public $video;
    /**
     * text to the image
     *
     * @var string $type
     * @var string $caption
     * @var string $title
     * @var integer $searchMessage
     * @var integer $open
     * @var boolean $following
     * @var boolean $expect
     */
    public $type;
    public $caption;
    public $title;
    public $searchMessage;
    public $open;
    public $following = false;
    public $expect = false;
    /**
     * attached file
     *
     * @var resource $videoFile
     */
    public $videoFile;
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
     * @var string $dialog
     * @var string $transition_id
     * @var array $transitions
     */
    public $dialog;
    public $transition_id;
    public $transitions = [];
    /**
     * intermediate id table
     *
     * @var integer $pivotId
     */
    public $pivotId;
    /**
     * selecting the transition type
     * @var string $context_type ;
     */
    public $context_type = 'messages';
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
     * @var integer $priority
     * @var string $delay_type
     */
    public $delay;
    public $priority;
    public $pad;
    public $delay_type = 'seconds';
    public $button_type = 'reply';
    public $all_messages;
    public $all_storylines;
    public $storyline_ids = null;
    public $option_transitions;

    protected function rules()
    {
        return Arr::wrap([
            'title' => 'required|min:3|max:64',
            'caption' => 'max:1024',
            'vd' => "max:51200",
        ]);
    }

    protected $messages = [
        'title.required' => '🖊️ поле не должно быть пустым',
        'title.min' => '🖊️ минимум 3 символа',
        'title.max' => '🖊️ не больше 64 символа',
        'caption.max' => '🖊️ ого лихо многовато текста, 1024 символа должно быть',
        'vd.file' => '📹 Выберете видео файл в формате mp4',
        'vd.mimes' => '📹 Видео не в mp4 формате',
        'vd.max' => '📹 Не более 50Мб'
    ];

    protected $listeners = [
        'copy' => 'copyDialog',
        'delete' => 'deleteDialog',
        'add' => 'getIdTransition',
        'radio' => 'radioModal',
        'selectMessage' => 'addMessage',
        'selectStoryline' => 'slcStoryline'];

    public function radioModal($value)
    {
        $this->context_type = $value;
        $this->search = null;
    }

    public function addMessage($id, $type)
    {
        $trn = $this->transition_id;
        $dialog = $this->video->transitions->first(function ($value, $key) use ($trn) {
            return $value->id === $trn;
        });
        $dialog->update(['storylinegable_id' => $id, "storylinegable_type" => 'App\\Models\\' . $type]);
        $this->isOpenWhere = false;
        return true;
    }

    public function getIdTransition($id)
    {
        $this->transition_id = $id;
        $this->isOpenWhere = true;
    }

    public function slcStoryline($id)
    {
        $this->all_messages = $this->collectStoryline($id);
        $this->storyline_ids = $id;
        $this->context_type = 'messages';
        $this->emit('selectRadio', 'messages');
        return $this->updating();
    }

    public function showInfo()
    {
    }

    public function close()
    {
        $this->open = false;
    }


    public function mount()
    {

        $this->caption = $this->video->caption;
        $this->title = $this->video->title;
        $this->pad = $this->video->option->pad;
        $option = $this->video->option;
        $this->delay = $option->delay;
        $this->delay_type = $option->delay_type;
        $this->priority = $option->priority;
        $this->following = $option->following;
        $this->expect = $option->expect;
        $this->button_type = $option->button_type;
        $this->option_transitions = Arr::wrap(['messages' => 'Сообщения', 'storylines' => 'Сюжеты']);
        $this->all_messages = $this->collectStoryline($this->video->storyline->first()->id);
        $this->all_storylines = Storyline::all();
    }

    /**
     * READY
     * creating transitions for buttons
     */
    public function addDummy()
    {
        $data = Arr::wrap(['name' => '']);
        $trs = new Transition($data);
        $this->video->transitions()->save($trs);
        $this->video = $this->video->fresh();
        return $this->mount();
    }

    /**
     * @param $id
     * @return bool
     */
    public function editDialog($id)
    {
        $first = $this->video->transitions->first(function ($value, $key) use ($id) {
            return $value->id === $id;
        });
        $first->delete();
        $this->video = $this->video->fresh();
        return $this->mount();
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteDialog($id)
    {
        $first = $this->video->transitions->first(function ($value, $key) use ($id) {
            return $value->id === $id;
        });
        $first->delete();
        $this->video = $this->video->fresh();
        return $this->mount();
    }

    /**
     * @param $id
     * @return bool
     */
    public function copyDialog($id)
    {
        $trs = Transition::select(["name", "storylinegable_type", "storylinegable_id", "transitiontable_type", "transitiontable_id"])->find($id);
        $data = new Transition($trs->toArray());
        $this->video->transitions()->save($data);
        $this->video = $this->video->fresh();
        return $this->mount();
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save()
    {
        $data = Arr::wrap(['title' => $this->title, 'caption' => $this->caption, 'vd' => $this->videoFile]);
        $validatedData = Validator::make($data, $this->rules(), $this->messages)->validate();

        if (is_null($this->videoFile)) {
            $this->video->update(['title' => $this->title, 'caption' => $this->caption]);
        } else {
            $path = Str::replaceFirst('storage/', '/public/', $this->video->url);
            Storage::delete($path);
            $uri = Storage::url($this->videoFile->store('public/video/step'));
            $this->video->update(['title' => $this->title, 'url' => $uri, 'caption' => $this->caption]);
        }

        $this->video->option->priority = $this->priority;
        $this->video->option->following = $this->following;
        $this->video->option->expect = $this->expect;
        $this->video->option->delay = $this->delay;
        $this->video->option->delay_type = $this->delay_type;
        $this->video->option->button_type = $this->button_type;
        $this->video->option->pad = $this->pad;
        $this->video->option->save();

        $this->video = Video::find($this->video->id);
        $this->open = true;
        session()->flash('message', 'Сохранилось');
        return false;
    }

    public function updatingSearch()
    {
        $srh = Str::of($this->search)->lower();
        switch ($this->context_type) {
            case 'messages':
                if (Str::length($this->search) > 1) {
                    $messages = $this->all_messages->filter(function ($value, $key) use ($srh) {
                        return Str::of(data_get($value, 'title'))->lower()->contains($srh);
                    });
                } elseif (Str::length($this->search) < 3 && !is_null($this->storyline_ids)) {
                    $messages = $this->collectStoryline($this->storyline_ids);
                } else {
                    $messages = $this->collectStoryline($this->video->storyline->first()->id);
                }
                $this->emit('updMessages', $messages);
                break;
            case 'storylines':
                if (Str::length($this->search) > 1) {
                    $storylines = $this->all_storylines->filter(function ($value, $key) use ($srh) {
                        return Str::of(data_get($value, 'name'))->lower()->contains($srh);
                    });
                } else {
                    $storylines = Storyline::all();
                }
                $this->emit('updStorylines', $storylines);
                break;
            default:
                break;
        }
    }

    public function updating()
    {
        $this->video->fresh();
    }

    public function updated()
    {

    }

    public function render()
    {
        return view('livewire.video.edit-video');
    }
}
