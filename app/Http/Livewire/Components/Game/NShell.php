<?php

namespace App\Http\Livewire\Components\Game;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Traits\ShellExec;

class NShell extends Component
{
    use ShellExec;

    public $game;
    public $game_process;

    public function mount()
    {
       $this->game_process = collect(json_decode($this->game->pid))->toArray();
    }

    public function setShell()
    {
        $shell_process = Arr::wrap(['high,default', 'last']);

        foreach ($shell_process as $process) {
            $pid = $this->background($process);
        }
        return $this->getShell();
    }

    public function getShell()
    {
        $list_pids = $this->is_running();
        $filter = collect($list_pids)->filter(function ($value, $key){
           return  Str::of($value)->is('*php artisan queue:list*') && !Str::contains($value, '12688');
        });
        $map = $filter->map(function ($value, $key){
            return Arr::wrap(['pid'=>Str::substr($value,9,7), 'process'=>Str::after($value, '--queue=')]);
        });
        $this->game->update(['pid' => collect($map)->toJson(JSON_PRETTY_PRINT)]);
        return $this->mount();
    }

    public function stopShell()
    {
        foreach ($this->game_process as $key => $item) {
            $pid = $this->kill(data_get($item, 'pid'));
        }
        $this->game->update(['pid' => null]);
        return $this->mount();
    }

    public function render()
    {
        return view('livewire.components.game.n-shell');
    }
}
