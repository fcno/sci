<?php

namespace Database\Factories;

use App\Models\Localidade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @see https://laravel.com/docs/8.x/database-testing
 * @see https://github.com/fzaninotto/Faker
 */
class LocalidadeFactory extends Factory
{
    protected $model = Localidade::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->city(),
        ];
    }
}
