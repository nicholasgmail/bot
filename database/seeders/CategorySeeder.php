<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Возможность', 'Расход', 'Благотворительность', 'День Х', 'Беременность', 'Потеря', 'Рынок', 'Знакомство'];
        $cell_number = ['1,3,5,7,9,11,13,15,17,19,21,23', '2,10,18', '4', '6,14,22', '12', '20', '8,16,24', 'not'];
        foreach ($categories as $key=>$category) {
            Category::create(['name' => $category, 'cell_number'=>$cell_number[$key]]);
        }
    }
}
