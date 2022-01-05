<?php

namespace App\Http\Livewire\Dialog;

use App\Models\DialogTelegram;
use Livewire\Component;

class AllDialog extends Component
{
    public $dialog;

    public function mount()
    {
        $this->dialog = DialogTelegram::all();
    }

    public function remove($id)
    {
        $dialog = DialogTelegram::find($id);
        if (isset($dialog->upshot))
            $dialog->upshot()->delete();
        $dialog->delete();
        return $this->mount();
    }

    public function render()
    {
        return view('livewire.dialog.all-dialog');
    }
}
