<?php

namespace Database\Factories;

use App\Models\Impressora;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @link https://laravel.com/docs/8.x/database-testing
 * @link https://github.com/fzaninotto/Faker
 */
class ImpressoraFactory extends Factory
{
    protected $model = Impressora::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->numerify(
                random_int(0, 1)
                    ? 'imp-#####'
                    : 'mlt-#####'
            )
        ];
    }
}
