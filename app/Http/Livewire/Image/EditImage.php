<?php

namespace App\Http\Livewire\Image;


use App\Traits\MessageCollect;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use App\Models\{Image, Storyline, Transition};
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class EditImage extends Component
{
    use WithFileUploads, MessageCollect;

    /**
     * a message with a picture to edit
     *
     * @var object $image
     * @var string $type
     * @var string $caption
     * @var string $title
     * @var string $searchMessage
     * @var string $open
     * @var boolean $following
     * @var boolean $expect
     */
    public $image;
    public $type;
    public $caption;
    public $title;
    public $searchMessage;
    public $open;
    public $following = false;
    public $expect = false;
    public $option_transitions;
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
     * @var integer $delay на сколько отдожить выполнение
     * @var string $delay_type что откладываем сикунды, минути, часы, дни
     * @var integer $priority приоритет, вес сообщения
     * @var string $weight вес рандома
     * @var array $btn_name назввание кнопки
     * @var array $btn_random случайная кнопка
     */
    public $delay;
    public $delay_type = 'seconds';
    public $priority;
    public $all_messages;
    public $pad;
    public $all_storylines;
    public $storyline_ids = null;
    public $weight;
    public $btn_name=[];
    public $btn_random=[];

    protected function rules()
    {
        return Arr::wrap([
            'title' => 'required|min:3|max:64',
            'caption' => 'max:1024',
            'ph' => "file|image|mimes:jpg|max:20128",
        ]);
    }

    protected $messages = [
        'title.required' => '🖊️ поле не должно быть пустым',
        'title.min' => '🖊️ минимум 3 символа',
        'title.max' => '🖊️ не больше 64 символа',
        'caption.max' => '🖊️ ого лихо многовато текста, 1024 символа должно быть',
        'ph.file' => '📷 Выберете файл в формате jpg',
        'ph.image' => '📷 Должна быть картинка jpg',
        'ph.mimes' => '📷 Картинка не в jpg формате',
        'ph.max' => '📷 Не более 20Мб'
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
        $dialog = $this->image->transitions->first(function ($value, $key) use ($trn) {
            return $value->id === $trn;
        });
        $dialog->update(['storylinegable_id' => $id, "storylinegable_type" => 'App\\Models\\' . $type]);
        return true;
    }
    public function getIdTransition($id){
        $this->transition_id = $id;
        $this->isOpenWhere = true;
    }
    public function slcStoryline($id)
    {
        $this->all_messages = $this->collectStoryline($id);
        $this->storyline_ids = $id;
        $this->context_type = 'messages';
        $this->emit('selectRadio', 'messages');
        //  $this->message = $this->message->fresh();
        return $this->updating();
    }

    public function close()
    {
        $this->open = false;
    }
    public function open()
    {
        $this->isOpenWhere = true;
    }

    public function mount()
    {

        $this->caption = $this->image->caption;
        $this->title = $this->image->title;
        $this->pad = $this->image->option->pad;
        $option = $this->image->option;
        $this->delay = $option->delay;
        $this->delay_type = $option->delay_type;
        $this->priority = $option->priority;
        $this->following = $option->following;
        $this->expect = $option->expect;
        $this->button_type = $option->button_type;
        $this->option_transitions = ['messages' => 'Сообщения', 'storylines' => 'Сюжеты'];
    }

    /**
     * READY
     * creating transitions for buttons
     */
    public function addDummy()
    {
        $data = Arr::wrap(['name' => '']);
        $trs = new Transition($data);
        $this->image->transitions()->save($trs);
        $this->image = $this->image->fresh();
        return $this->mount();
    }

    /**
     * @param $id
     * @return bool
     */
    public function editDialog($id)
    {
        $first = $this->image->transitions->first(function ($value, $key) use ($id) {
            return $value->id === $id;
        });
        $first->delete();
        $this->image = $this->image->fresh();
        return $this->mount();
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteDialog($id)
    {
        $first = $this->image->transitions->first(function ($value, $key) use ($id) {
            return $value->id === $id;
        });
        $first->delete();
        $this->image = $this->image->fresh();
        return $this->hydrate();
    }

    /**
     * @param $id
     * @return bool
     */
    public function copyDialog($id)
    {
        $trs = Transition::select(["name", "storylinegable_type", "storylinegable_id", "transitiontable_type", "transitiontable_id"])->find($id);
        $data = new Transition($trs->toArray());
        $this->image->transitions()->save($data);
        $this->image = $this->image->fresh();
        return $this->mount();
    }

    public function save()
    {
        $data = Arr::wrap(['title' => $this->title, 'caption' => $this->caption, 'photo' => $this->photoFile]);
        $validatedData = Validator::make($data, $this->rules(), $this->messages)->validate();

        if (is_null($this->photoFile)) {
            $this->image->update(['title' => $this->title, 'caption' => $this->caption]);
        } else {
            $ollImg = Image::where('url', $this->image->url)->count();
            if ($ollImg == 1) {
                $path = Str::replaceFirst('storage/', '/public/', $this->image->url);
                Storage::delete($path);
            }
            $url = Storage::url($this->photoFile->store('public/images/step'));
            $this->image->update(['title' => $this->title, 'url' => $url, 'caption' => $this->caption]);
        }

        $this->image->option->priority = $this->priority;
        $this->image->option->delay = $this->delay;
        $this->image->option->delay_type = $this->delay_type;
        $this->image->option->following = $this->following;
        $this->image->option->expect = $this->expect;
        $this->image->option->button_type = 'reply';
        $this->image->option->save();
        $this->image->option()->update(['pad' =>$this->pad]);

        $this->image = Image::find($this->image->id);
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
                    $messages = $this->collectStoryline($this->image->storyline->first()->id);
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

    public function hydrate()
    {
        $this->all_storylines = Storyline::all();
        $this->all_messages = $this->collectStoryline($this->image->storyline->first()->id);
    }

    public function updating()
    {
        $this->image->fresh();
    }

    public function updated()
    {
    }

    public function render()
    {
        return view('livewire.image.edit-image');
    }
}
