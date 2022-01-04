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
            // Evitar gerar números repetidos no auto relacionamento
            'id' => $this->faker->unique()->numberBetween(int1: 10000),
            'nome' => $this->faker->jobTitle(),
        ];
    }
}
