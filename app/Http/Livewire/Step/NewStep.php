<?php

namespace App\Http\Livewire\Step;

use App\Models\Step;
use Livewire\Component;

class NewStep extends Component
{
    public $name = '';
    public $allStep;

    protected $rules = [
        'name' => 'required|min:3|max:64',
    ];

    public function addStep()
    {
        $this->validate();
        Step::create(['name' => $this->name]);
        $this->allStep = Step::all();
        $this->name = '';
    }

    public function mount()
    {
        $this->allStep = Step::all();
    }

    public function removeStep($id)
    {
        $step = Step::find($id);
       /* $deleted = $step->deleteStep;
        if ( $deleted === null ) {*/
        $step->images()->delete();
        $step->storyline()->detach();
            $step->delete();
       /* }*/
        $this->updated($this->allStep);
    }

    public function updated($allStep)
    {
        $this->allStep = Step::all();
    }

    public function render()
    {
        return view('livewire.step.new-step');
    }
}
