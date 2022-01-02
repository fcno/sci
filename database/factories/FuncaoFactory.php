<?php

namespace Database\Factories;

use App\Models\Funcao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @see https://laravel.com/docs/8.x/database-testing
 * @see https://github.com/fzaninotto/Faker
 */
class FuncaoFactory extends Factory
{
    protected $model = Funcao::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->randomNumber(),
            'nome' => $this->faker->jobTitle(),
        ];
    }
}
