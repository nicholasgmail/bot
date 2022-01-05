<?php

namespace App\Http\Livewire\Components\Tabs\kitsPage;

use Illuminate\Support\Arr;
use Livewire\Component;

class RandomTabs extends Component
{
   /* public $tabs;
    public $tab;
    public $kits;
    public $salute;
    public $emoji;
    public $mistake;*/

    /*"salute", 'emoji', 'mistake', 'men', 'women'*/
    public function mount()
    {
        dump('$this->kits');exit;
       /* $this->tabs = Arr::wrap(['greetings' => 'Приветствие', 'emoji' => 'Емодзи', 'mistake' => 'Ошибки']);
        $this->tab = 'greetings';
        $this->salute = data_get($this->kits, 'salute');
        $this->emoji = data_get($this->kits, 'emoji');
        $this->mistake = data_get($this->kits, 'mistake');*/
    }

    /*public function updatingkits()
    {
        $this->kits = $this->kits->fresh();
    }

    public function get()
    {
        switch ($this->tab) {
            case 'greetings':
                $this->salute = data_get($this->kits, 'salute');
                break;
            case 'emoji':
                $this->emoji = data_get($this->kits, 'emoji');
                break;
            case 'mistake':
                $this->mistake = data_get($this->kits, 'mistake');
                break;
        }
    }

    public function updatedSalute()
    {
        $this->kits->update(['salute' => sprintf('%s' . PHP_EOL, $this->salute)]);
    }

    public function updatedEmoji()
    {
        $this->kits->update(['emoji' => sprintf('%s' . PHP_EOL, $this->emoji)]);
    }

    public function updatedMistake()
    {
        $this->kits->update(['mistake' => sprintf('%s' . PHP_EOL, $this->mistake)]);
    }*/

    public function render()
    {
        return view('livewire.components.tabs.kits-page.random-tabs');
    }
}
