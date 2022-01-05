<?php

namespace App\Http\Livewire\Storyline;

use Illuminate\Support\Arr;
use App\Models\{Storyline, Category};
use Livewire\Component;

class UpdateStoryline extends Component
{
    /**
     * @var object $storyline переменная передана из контроллера
     * @var string $name имя сюжета
     * @var boolean $close закрытие уведомления
     * @var boolean $get_know чек бокс выбор типа сюжета
     */
    public $storyline;
    public $name;
    public $open = false;
    public $hide;
    public $categotrie;
    public $category;
    public $show_level;
    public $category_value;
    public $game_types;
    public $selected_games = [];

    /**
     * @return false
     */
    public function close()
    {
        return $this->open = false;
    }

    /**
     * @return false
     */
    public function mount()
    {
        $this->name = $this->storyline->name ?? '';
        $this->hide = $this->storyline->hide;
        $this->show_level = $this->storyline->show_level;
        $this->categotrie = Category::get();
        $this->category = $this->storyline->categories->first();
        if (!is_null($this->category)) {
            $this->category_value = $this->category->id;
        }
        $this->game_types = Arr::wrap(['first_train' => 'Первая треня', 'regular_train' => 'Обычная треня', 'raid' => 'Рейд', 'battle' => 'Батл', 'test' => 'Тестовый']);
        $this->selected_games = json_decode($this->storyline->train);
        return true;
    }

    /**
     * @return false
     */
    public function save()
    {
        $this->storyline->update(['name' => $this->name]);
        $this->open = true;
        $this->category = $this->storyline->categories->first();
        $this->storyline->update(['train' => collect($this->selected_games)->toJson(JSON_PRETTY_PRINT)]);
        $this->storyline->fresh();
        if (!is_null($this->category)) {
            $ct = Category::find($this->category->id);
            $ct = $ct->storyline()->wherePivot('storyline_id', $this->storyline->id);
            $ct->detach();
        }
        $st = Storyline::find($this->storyline->id);
        $st->categories()->attach($this->category_value);

        /* if($this->storyline->categories->isNotEmpty()){
             $this->categotrie->storyline()->detach($this->storyline->id);
             $this->storyline->categories()->attach($this->category->id);
         }else{

         }*/
        session()->flash('message', 'Сохранилось');
        return $this->mount();
    }

    /**
     * @param
     */
    public function updatedHide()
    {
        $this->storyline->update(['hide' => $this->hide]);
        return $this->mount();
    }

    /**
     * @param
     */
    public function updatedShowLevel()
    {
        $this->storyline->update(['show_level'=>$this->show_level]);
        return $this->mount();
    }

    /**
     * @param $storyline
     */
    public function updeted($storyline)
    {
        $this->storyline = Storyline::findOrFile($this->storyline->id);
    }


    public function render()
    {
        return view('livewire.storyline.update-storyline');
    }
}
