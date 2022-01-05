<?php

namespace App\Http\Livewire\Storyline;

use Illuminate\Support\Facades\Hash;
use App\Traits\{MessageCollect, HelpersStoryline};
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\{DialogTelegram, Image, Message, Option, Pushbutton, Video, Storyline};
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class NewMessage extends Component
{
    use WithFileUploads, MessageCollect, HelpersStoryline;

    public $storyline;
    public $text;
    public $title;
    public $priority = 1;
    public $delay_type = 'seconds';
    public $delay = 0;
    public $idStoryline;
    public $allMessages;
    public $confirmingUserDeletion;
    public $option = "message";
    public $message;
    public $open_test;
    public $image;
    public $video;
    public $photoFile;
    public $videoFile;
    public $allButtons;
    public $buttons = [];
    public $editId;
    public $following = false;
    public $isOpenWhere = false;
    public $button_type = 'inline';
    public $option_transitions;
    public $all_messages;
    public $storyline_ids;
    public $hash;

    /**
     * selecting the transition type
     * @var string $context_type ;
     */
    public $context_type = 'messages';

    protected $listeners = [
        'copy' => 'copyDialog',
        'close' => 'toggle',
        'delete' => 'deleteDialog',
        'add' => 'getIdTransition',
        'radio' => 'radioModal',
        'copyItem' => 'setStoryline',
        'selectStoryline' => 'slcStoryline'];

    public function setStoryline()
    {
        $this->emit('setStoryline', $this->idStoryline);
    }

    public function radioModal($value)
    {
        $this->context_type = $value;
        $this->search = null;
    }

    public function getIdTransition($id)
    {
        $this->transition_id = $id;
        $this->isOpenWhere = true;
    }

    public function close()
    {
        $this->confirmingUserDeletion = false;
    }

    public function open()
    {
        $this->isOpenWhere = true;
    }

    public function toggle()
    {
        $this->isOpenWhere = !$this->isOpenWhere;
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
        $msg = $this->getCollectStoryline($this->idStoryline);
        $last = $msg->last();
        $priority = data_get($last, 'option.priority');
        return new Option(['priority' => $priority + 1, 'delay' => $this->delay, 'delay_type' => $this->delay_type, 'button_type' => $this->button_type, 'following' => $this->following]);
    }

    /**
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addContent()
    {
        $validatedData = Validator::make(
            ['title' => $this->title],
            ['title' => "required|min:3|max:64"],
            ['required' => '🖊️ постарайся и пойдем дальше',
                'min' => '🖊️ минимум 3 символа',
                'max' => '🖊️ не больше 64 символа должно быть']
        )->validate();
        $validatedData = Validator::make(
            ['text' => $this->text],
            ['text' => "required|min:1|max:1024"],
            ['required' => '🖊️ поле должно быть заполнено',
                'min' => '🖊️ незаполнено',
                'max' => '🖊️ не больше 1024 символа должно быть']
        )->validate();

        if ($this->image) {
            $validatedData = Validator::make(
                ['photoFile' => $this->photoFile],
                ['photoFile' => "required|file|image|mimes:jpg|max:10048"],
                ['required' => '📷 Выберете файл',
                    'file' => '📷 Выберете файл в формате jpg',
                    'image' => '📷 Должна быть картинка jpg',
                    'mimes' => '📷 Картинка не в jpg формате',
                    'max' => '📷 Не более 10Мб'],
            )->validate();

            $url = Storage::url($this->photoFile->store('public/images/storyline'));
            $image = new Image(['title' => $this->title, 'url' => $url, 'caption' => $this->text]);
            $option = $this->optionAdd();
            //$storyline = Storyline::findOrFail($this->idStoryline);
            $mage = $this->storyline->images()->save($image);
            $mage->option()->save($option);
            /*$dates =  $storyline->images;
            foreach ($dates as $date){
                dump($date->pivot->where(function (Builder $query){
                    return $query->where('storylinegable_id', 21);
                })->get());
            }exit;*/
        } elseif ($this->video) {

            $validatedData = Validator::make(
                ['videoFile' => $this->videoFile],
                ['videoFile' => "required|file|mimetypes:video/mp4|max:51200"],
                ['required' => '📹 Выберете файл',
                    'file' => '📹 Выберете видео файл в формате mp4',
                    'mimetypes' => '📹 Видео не в mp4 формате',
                    'max' => '📹 Не более 50Мб']
            )->validate();
            $url = Storage::url($this->videoFile->store('public/video/storyline'));
            $video = new Video(['title' => $this->title, 'url' => $url, 'caption' => $this->text]);
            $option = $this->optionAdd();
            //$storyline = Storyline::findOrNew($this->idStoryline);
            $deo = $this->storyline->videos()->save($video);
            $deo->option()->save($option);
        } else {
            $message = new Message(['title' => $this->title, 'caption' => $this->text]);
            $option = $this->optionAdd();
            // $storyline = Storyline::findOrNew($this->idStoryline);
            $ssage = $this->storyline->messages()->save($message);
            $ssage->option()->save($option);
        }
        $this->text = '';
        $this->title = '';
        $this->photoFile = '';
        $this->videoFile = '';
        return $this->hydrate();
    }

    /**
     * getting a set of messages && videos && images
     */
    public function mount()
    {
        $msg = $this->getCollectStoryline($this->idStoryline);
        $this->allMessages = array_values(Arr::sort($msg, function ($value) {
            return data_get($value, 'option.priority');
        }));
        $this->option_transitions = ['messages' => 'Сообщения', 'storylines' => 'Сюжеты'];
        if (is_null($this->storyline->hash)) {
            $hash = md5(rand(111111, 999999));
            $this->storyline->update(['hash' => $hash]);
        }
        $this->hash = $this->storyline->hash;
    }

    public function gen()
    {
        $hash = md5(rand(111111, 999999));
        $this->storyline->update(['hash' => $hash]);
        return $this->mount();
    }

    public function hydrate()
    {
        $msg = $this->getCollectStoryline($this->idStoryline);
        $this->allMessages = array_values(Arr::sort($msg, function ($value) {
            return data_get($value, 'option.priority');
        }));

        $this->all_storylines = Storyline::all();
        $this->all_messages = $this->getCollectStoryline($this->idStoryline);
    }

    public function removeMessage($key)
    {
        $item = $this->allMessages[$key];
        switch (data_get($item, 'pivot.storylinegable_type')) {
            case Message::class :
                $message = Message::find(data_get($item, 'id'));
                $message->storyline()->detach();
                $message->option()->delete();
                $message->delete();
                break;
            case Image::class :
                $image = Image::find(data_get($item, 'id'));
                $ollImg = Image::where('url', $image->url)->count();
                if ($ollImg == 1) {
                    $path = Str::replaceFirst('storage/', '/public/', $image->url);
                    Storage::delete($path);
                }
                $image->storyline()->detach();
                $image->option()->delete();
                $image->delete();
                break;
            case Video::class :
                $video = Video::find(data_get($item, 'id'));
                $ollImg = Video::where('url', $video->url)->count();
                if ($ollImg == 1) {
                    $path = Str::replaceFirst('storage/', '/public/', $video->url);
                    Storage::delete($path);
                }
                $video->storyline()->detach();
                $video->option()->delete();
                $video->delete();
                break;
            default:
                break;
        };
        return $this->hydrate();
    }

    public function slcStoryline($id)
    {
        $this->all_messages = $this->getCollectStoryline($id);
        $this->storyline_ids = $id;
        $this->context_type = 'messages';
        $this->emit('selectRadio', 'messages');
        //  $this->message = $this->message->fresh();
        return $this->updating();
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
                    $messages = $this->getCollectStoryline($this->storyline_ids);
                } else {
                    $messages = $this->getCollectStoryline($this->image->storyline->first()->id);
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

    public function openPushbutton($id)
    {
        $this->confirmingUserDeletion = true;
        $this->editId = $id;

    }

    public function test($id, $class)
    {

        $dialog = DialogTelegram::get();
        $message = $this->getMessage($class, $id);
        $this->open_test = true;
        $str = $this->getCaption(null, $dialog->last()->id, $message->caption);
        session()->flash('test', $str);
    }

    /**
     * @param collection $allMessages
     */
    public function updated()
    {

        $msg = $this->getCollectStoryline($this->idStoryline);
        $this->allMessages = array_values(Arr::sort($msg, function ($value) {
            return data_get($value, 'option.priority');
        }));
        /**
         * switching radio button
         */
        switch ($this->option) {
            case 'message' :
                $this->image = false;
                $this->video = false;
                break;
            case 'image' :
                $this->image = true;
                $this->video = false;
                break;
            case 'video' :
                $this->image = false;
                $this->video = true;
                break;
            default:
                break;
        };
    }

    public function render()
    {
        return view('livewire.storyline.new-message');
    }
}
