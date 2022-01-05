<?php

namespace App\Http\Livewire\Components\Tabs;

use Illuminate\Support\Arr;
use Livewire\Component;

class Kits extends Component
{
    public $tabs;
    public $tab;
    public $kits;
    public $salute;
    public $men;
    public $women;
    public $emoji;
    public $open = false;
    public $mistake;

    /*"salute", 'emoji', 'mistake', 'men', 'women'*/
    public function mount()
    {
        $this->tabs = Arr::wrap(['greetings' => 'Приветствие', 'emoji' => 'Емодзи', 'mistake' => 'Ошибки', 'men' => 'Мужские', 'women' => 'Женские']);
        $this->tab = 'greetings';
        $this->salute = $this->kits->first()->salute;
        $this->emoji = $this->kits->first()->emoji;
        $this->mistake = $this->kits->first()->mistake;
        $this->men = $this->kits->first()->men;
        $this->women = $this->kits->first()->women;
    }

    public function updatingkits()
    {
        return $this->mount();
    }

    public function save()
    {
        $data = Arr::wrap(['salute' => sprintf('%s', $this->salute),
            'emoji' => sprintf('%s', $this->emoji),
            'mistake' => sprintf('%s', $this->mistake),
            'men' => sprintf('%s', $this->men),
            'women' => sprintf('%s', $this->women)
        ]);
        if (!$this->kits->count()) {
            $this->kits->create($data);
        }
        $this->kits->first()->update($data);
        session()->flash('message', 'Сохранилось');
        $this->open = true;
    }

    /**
     * @return false
     */
    public function close()
    {
        return $this->open = false;
    }

    public function render()
    {
        return view('livewire.components.tabs.kits');
    }
}
