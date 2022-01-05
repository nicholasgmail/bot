<?php

namespace App\Http\Livewire\Components\Table;

use App\Models\Image;
use App\Models\Message;
use App\Models\Option;
use App\Models\Storyline;
use App\Models\Transition;
use App\Models\Video;
use Livewire\Component;

class ItemCopy extends Component
{
    public $item;
    public $checked;

    protected $listeners = ['setStoryline' => 'copy'];

    public function copy($id)
    {
        $storyline = Storyline::findOrFail($id);
        $new_message = null;
        if ($this->checked) {
            switch (class_basename(data_get($this->item, 'pivot.storylinegable_type'))) {
                case 'Message' :
                    $new_message = new Message(['title' => data_get($this->item, 'title'), 'caption' => data_get($this->item, 'caption')]);
                    $storyline->messages()->save($new_message);
                    break;
                case 'Image' :
                    $new_message = new Image(['title' => data_get($this->item, 'title'), 'caption' => data_get($this->item, 'caption'), 'url' => data_get($this->item, 'url')]);
                    $storyline->images()->save($new_message);
                    break;
                case 'Video' :
                    $new_message = new Video(['title' => data_get($this->item, 'title'), 'caption' => data_get($this->item, 'caption'), 'url' => data_get($this->item, 'url')]);
                    $storyline->videos()->save($new_message);
                    break;
                default:
                    break;
            };
            foreach (data_get($this->item, 'transitions') as $item) {
                $transition = new Transition($item);
                $new_message->transitions()->save($transition);
            }
            $options = new Option(data_get($this->item, 'option'));
            $new_message->option()->save($options);
            $this->checked = false;
        }
    }

    public function render()
    {
        return view('livewire.components.table.item-copy');
    }
}
