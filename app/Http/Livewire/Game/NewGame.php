<?php

namespace App\Http\Livewire\Game;

use App\Models\Game;
use Livewire\Component;

class NewGame extends Component
{
    public $name = '';
    public $allGame;

    protected $rules = [
        'name' => 'required|min:3|max:64',
    ];

    public function addGame()
    {
        $this->validate();
        Game::create(['name' => $this->name]);
        $this->name = '';

        return  $this->updated($this->allGame);
    }

    public function mount()
    {
        $this->allGame = Game::all();
    }

    public function removeGame($id)
    {
        $step = Game::find($id);
        $deleted = $step->deleteGame;
        if ( $deleted === null ) {
            $step->delete();
        }
        return $this->updated($this->allGame);
    }

    public function updated($allGame)
    {
        $this->allGame = Game::all();
    }


    public function render()
    {
        return view('livewire.game.new-game');
    }
}
