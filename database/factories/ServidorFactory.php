<?php

namespace Database\Factories;

use App\Models\Servidor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @link https://laravel.com/docs/8.x/database-testing
 * @link https://github.com/fzaninotto/Faker
 */
class ServidorFactory extends Factory
{
    protected $model = Servidor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->lexify('??????????@example.org')
        ];
    }
}
