<?php

namespace App\Http\Livewire\Storyline;

use App\Models\Category;
use App\Models\Image;
use App\Models\Message;
use App\Models\Option;
use App\Models\Storyline;
use App\Models\Transition;
use App\Models\Video;
use Illuminate\Support\Str;
use App\Traits\{MessageCollect, HelpersStoryline};
use Illuminate\Support\Arr;
use Livewire\Component;

class NewStoryline extends Component
{

    use HelpersStoryline, MessageCollect;

    public $name = '';
    public $allStoryline;
    public $collect;
    public $search;

    protected $rules = [
        'name' => 'required|min:3|max:64',
    ];

    public function addStoryline()
    {
        $this->validate();
        Storyline::create(['name' => $this->name]);
        $this->allStoryline = Storyline::all();
        $this->name = '';
    }

    public function mount()
    {
        $this->allStoryline = Storyline::all();
    }

    public function removeStoryline($id)
    {
        $storyline = Storyline::find($id);
        $ct = $storyline->categories;
        if ($storyline->categories->isNotEmpty()) $svCategory = $storyline->categories()->detach($ct->first()->id);
        $messages = $storyline->messages;
        $images = $storyline->images;
        $videos = $storyline->videos;
        foreach ($messages as $message) {
            $message->option()->delete();
            $transitions = $message->transitions;
            foreach ($transitions as $transition) {
                $transition->delete();
            }
            $message->delete();
        };
        foreach ($images as $message) {
            $message->option()->delete();
            $transitions = $message->transitions;
            $ollImg = Image::where('url', $message->url)->count();
            if ($ollImg == 1) {
                $path = Str::replaceFirst('storage/', '/public/', $ollImg->url);
                Storage::delete($path);
            }
            foreach ($transitions as $transition) {
                $transition->delete();
            }
            $message->delete();
        };
        foreach ($videos as $message) {
            $message->option()->delete();
            $transitions = $message->transitions;
            $ollVD = Video::where('url', $message->url)->count();
            if ($ollVD == 1) {
                $path = Str::replaceFirst('storage/', '/public/', $ollVD->url);
                Storage::delete($path);
            }
            foreach ($transitions as $transition) {
                $transition->delete();
            }
            $message->delete();
        };
        $deleted = $storyline->deleteStep;
        if ($deleted === null) {
            $storyline->delete();
        }
        $this->updated($this->allStoryline);
    }

    public function updatedSearch()
    {
        $srh = Str::of($this->search)->lower();
        if (Str::length($this->search) > 1) {
            $this->allStoryline = $this->allStoryline->filter(function ($v) {
                return Str::of(data_get($v, 'name'))->lower()->contains(Str::of($this->search)->lower()) ||
                    Str::of(data_get($v, 'hash'))->lower()->contains(Str::of($this->search)->lower());
            });
            /*  dump($this->allStoryline);
              if (is_null($this->allStoryline)) {
                  $this->allStoryline = $this->allStoryline->filter(function ($v) {
                      return Str::of(data_get($v, 'hash'))->lower()->contains(Str::of($this->search)->lower());
                  });
              }*/
        } else {
            $this->allStoryline = Storyline::all();
        }

    }

    public function updated()
    {
        $this->allStoryline = Storyline::all();
    }

    public function copyStoryline($id)
    {
        $collect_first = collect();
        $strl = Storyline::find($id);
        $messages = $strl->messages;
        $images = $strl->images;
        $videos = $strl->videos;
        $collect_first = $this->getCollectStoryline($id);

        //получение нового сюжета из даными старого сюжета
        $data = new Storyline($strl->toArray());
        $ct = $strl->categories;
        $saveSt = $data->save();
        $svCategory = $data->categories()->attach($ct->first()->id);
        foreach ($messages as $message) {
            $dtMs = new Message($message->toArray());
            $ms = $data->messages()->save($dtMs);
            $option = $message->option;
            $opMs = new Option($option->toArray());
            $dtMs->option()->save($opMs);
        };
        foreach ($images as $message) {
            $dtMs = new Image($message->toArray());
            $ms = $data->images()->save($dtMs);
            $option = $message->option;
            $opMs = new Option($option->toArray());
            $dtMs->option()->save($opMs);
        };
        foreach ($videos as $message) {
            $dtMs = new Video($message->toArray());
            $ms = $data->videos()->save($dtMs);
            // $transitions = $message->transitions;
            $option = $message->option;
            $opMs = new Option($option->toArray());
            $dtMs->option()->save($opMs);
        };
        $collect_last = $this->getCollectStoryline($data->id);

        foreach ($collect_last as $key => $item) {
            $trs = data_get($collect_first[$key], 'transitions');
            $msg = collect();
            foreach ($trs as $tr) {
                $tr_ms = $collect_first->first(function ($value, $key) use ($tr) {
                    $value = $value->prepend($key, 'key');
                    return data_get($value, 'id') == data_get($tr, 'storylinegable_id') && data_get($value, 'option.optiontable_type') == data_get($tr, 'storylinegable_type');
                });
                if (is_null($tr_ms)) {
                    $msg = $msg->push(null);
                } else {
                    $tr_ms = $tr_ms->shift();
                    $msg = $msg->push($tr_ms);
                }
            }
            $msg_id = $msg->map(function ($value, $key) use ($collect_last) {
                return $collect_last[$value]['id'] ?? null;
            });

            foreach ($trs as $key => $transition) {
                $dt = new Transition($transition->toArray());
                $msg_first = $this->getMessage(class_basename(data_get($item, 'option.optiontable_type')), data_get($item, 'id'));
                $trs_next = $msg_first->transitions()->save($dt);
                if (!is_null($msg_id[$key])) {
                    $trs_next->update(['storylinegable_id' => $msg_id[$key]]);
                }
            }
        }

        $this->updated($this->allStoryline);
    }

    public function render()
    {
        return view('livewire.storyline.new-storyline');
    }
}
