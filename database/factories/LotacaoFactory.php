<?php

namespace Database\Factories;

use App\Models\Lotacao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @see https://laravel.com/docs/8.x/database-testing
 * @see https://github.com/fzaninotto/Faker
 */
class LotacaoFactory extends Factory
{
    protected $model = Lotacao::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'lotacao_pai' => null,
            'id' => $this->faker->unique()->randomNumber(),
            'nome' => $this->faker->company(),
            'sigla' => $this->faker->word(),
        ];
    }
}
