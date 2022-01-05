<?php

namespace App\Http\Livewire\Components\Card;

use App\Models\Image;
use App\Models\Message;
use App\Models\Video;
use Livewire\Component;

class InfoTransiton extends Component
{
    /**
     * @var $transition обект перехода
     * @var $title заголовок куда перехода
     */
    public $transition;
    public $title;
    public $ms_id;
    protected $listeners = ['selectMessage' => 'updated'];

    public function mount()
    {
        $type = class_basename(data_get($this->transition, 'storylinegable_type'));
        $id = class_basename(data_get($this->transition, 'storylinegable_id'));
        $text = '👻 Пустышка!!!';
        $text = sprintf('%s' . PHP_EOL, $text);
        switch ($type) {
            case 'Message' :
                $text = Message::findOrFail($id);
                $this->title = data_get($text, 'title');
                $this->ms_id = data_get($text, 'id');
                break;
            case 'Image' :
                $text = Image::findOrFail($id);
                $this->title = data_get($text, 'title');
                $this->ms_id = data_get($text, 'id');
                break;
            case 'Video' :
                $text = Video::findOrFail($id);
                $this->title = data_get($text, 'title');
                $this->ms_id = data_get($text, 'id');
                break;
            default:
                $this->title = $text;
                $this->ms_id ='';
                break;
        };
    }

    public function updating()
    {
        $this->transition = $this->transition->fresh();
    }

    public function updated()
    {
        $this->mount();
    }

    public function render()
    {
        return view('livewire.components.card.info-transiton');
    }
}
