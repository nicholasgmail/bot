<?php

namespace App\Http\Livewire\Category;


use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class EditCustomizing extends Component
{
    /**
     * @var string $name
     * @var string $cell_number
     */
    public $name;
    public $cell_number;
    /**
     * @var object $сategory
     */
    public $category;



    /**
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updCategory()
    {
        return $this->category->update(['name'=>$this->name, 'cell_number'=>$this->cell_number]);
    }


    public function mount()
    {
        $this->name = $this->category->name;
        $this->cell_number = $this->category->cell_number;
    }

    public function updated()
    {
    }

    public function render()
    {
        return view('livewire.category.edit-customizing');
    }
}
