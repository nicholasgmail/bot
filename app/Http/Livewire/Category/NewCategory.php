<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;

class NewCategory extends Component
{
    /**
     * @var string
     */
    public $name = '';
    /**
     * @var array
     */
    public $categories;

    protected $rules = [
        'name' => 'required|min:3|max:64',
    ];

    public function addCategory()
    {
        $this->validate();
        Category::create(['name' => $this->name]);
        $this->categories = Category::all();
        $this->name = '';
    }

    public function mount()
    {

    }

    public function removeStep($id)
    {
        $category = Category::find($id);
        return $category->delete();
    }

    public function updated($categories)
    {
        $this->categories = Category::all();
    }
    public function render()
    {
        return view('livewire.category.new-category');
    }
}
