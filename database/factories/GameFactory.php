<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Тренировка',
            'salute' => 'ПРИВЕТ, АЛОХА, САЛЮТ, ХАЙ, ХЕЛЛОУ, НИХАО, БОНЖУР, ОЛА, БОНЖОРНО, МИРХАБА, ЗДОРОВ, САВАДДИ, САЛЮТИ',
            'first_train' => '1111',
            'regular_train' => '2222',
            'raid' => '3333',
            'battle' => '4444',
            'field_size' => 24,
        ];
    }
}
