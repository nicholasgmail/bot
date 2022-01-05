<?php

namespace App\Http\Livewire\Message;


use App\Models\Storyline;
use App\Models\Transition;
use App\Traits\MessageCollect;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditMessage extends Component
{
    use WithFileUploads, MessageCollect;

    /**
     * a message with a picture to edit
     *
     * @var object $message
     */
    public $message;

    /**
     * @var string $type
     * @var string $caption
     * @var string $title
     * @var string $searchMessage
     * @var string $open
     * @var boolean $following
     * @var boolean $expect
     * @var array $option_transitions
     */
    public $type;
    public $caption;
    public $title;
    public $searchMessage;
    public $open;
    public $following = false;
    public $expect = false;
    public $option_transitions;

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
     * @var integer $delay
     * @var string $delay_typ
     * @var integer $priority
     */
    public $delay;
    public $delay_type = 'seconds';
    public $priority;
    public $button_type = 'reply';
    public $all_messages;
    public $all_storylines;
    public $storyline_ids = null;
    public $weight;
    public $pad;
    public $casts;
    public $btn_name = [];
    public $btn_random = [];

    protected $messages = [
        'title.required' => '🖊️ поле не должно быть пустым',
        'title.min' => '🖊️ минимум 3 символа',
        'title.max' => '🖊️ не больше 64 символа',
        'name_transition.required' => '🖊️ нет текста диалога',
        'name_transition.min' => '🖊️ минимум 3 символа',
        'name_transition.max' => '🖊️ не больше 64 символа',
        'caption.max' => '🖊️ ого лихо многовато текста, 1024 символа должно быть',
    ];
    protected $messageTrs = [
        'name_transition.required' => '🖊️ нет текста диалога',
        'name_transition.min' => '🖊️ минимум 3 символа',
        'name_transition.max' => '🖊️ не больше 64 символа',
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
        $dialog = $this->message->transitions->first(function ($value, $key) use ($trn) {
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
        //  $this->message = $this->message->fresh();
        return $this->updating();
    }

    public function close()
    {
        $this->open = false;
    }

    public function mount()
    {
        $this->caption = $this->message->caption;
        $this->title = $this->message->title;
        $this->pad = $this->message->option->pad;
        $option = $this->message->option;
        $this->delay = $option->delay;
        $this->delay_type = $option->delay_type;
        $this->priority = $option->priority;
        $this->following = $option->following;
        $this->expect = $option->expect;
        $this->button_type = $option->button_type;
        $this->option_transitions = Arr::wrap(['messages' => 'Сообщения', 'storylines' => 'Сюжеты']);
    }

    public function addDummy()
    {
        $data = Arr::wrap(['name' => '']);
        $trs = new Transition($data);
        $this->message->transitions()->save($trs);
        $this->message = $this->message->fresh();
        return $this->mount();
    }

    /**
     * @param $id
     * @return bool
     */
    public function editDialog($id)
    {
        $first = $this->message->transitions->first(function ($value, $key) use ($id) {
            return $value->id === $id;
        });
        $first->delete();
        $this->message = $this->message->fresh();
        return $this->mount();
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteDialog($id)
    {
        $first = $this->message->transitions->first(function ($value, $key) use ($id) {
            return $value->id === $id;
        });
        $first->delete();
        $this->message = $this->message->fresh();
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
        $this->message->transitions()->save($data);
        $this->message = $this->message->fresh();
        return $this->mount();
    }


    /**
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save()
    {
        $data = Arr::wrap(['title' => $this->title, 'caption' => $this->caption]);
        // $validatedData = Validator::make($data, $this->rules(), $this->messages)->validate();

        $this->message->update(['caption' => $this->caption, 'title' => $this->title]);
        $this->message->option->priority = $this->priority;
        $this->message->option->delay = $this->delay;
        $this->message->option->following = $this->following;
        $this->message->option->expect = $this->expect;
        $this->message->option->delay_type = $this->delay_type;
        $this->message->option->button_type = $this->button_type;
        $this->message->option->pad = $this->pad;
        $this->message->option->save();

        session()->flash('message', 'Сохранилось');
        $this->open = true;
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
                    $messages = $this->collectStoryline($this->message->storyline->first()->id);
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
        $this->all_messages = $this->collectStoryline($this->message->storyline->first()->id);
    }

    public function updating()
    {
        $this->message->fresh();
    }

    public function updated()
    {
       /* sleep(5);
        $balances = 3000;
        $price = 1000;*/

        /* $srlz = serialize($this->casts);
         $rt = (boolean)(unserialize($srlz));
      $arr = collect(['balances' => $balances, 'price' => $price])->toArray();*/
        /*  $blad = Blade::compileString(trim($this->casts));*/
        // $srlz = serialize($blad);
        // $rt = (boolean)(unserialize($srlz));
        //$rt = sprintf('%s' . PHP_EOL, $this->casts);
        // $rt = sprintf('%s', trim($this->casts));
     /*   $rt = trim($this->casts);

             dump(eval("return $rt;"));
        exit;*/
    }


    public function render()
    {
        return view('livewire.message.edit-message');
    }
}
