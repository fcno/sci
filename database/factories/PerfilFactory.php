<?php

namespace Database\Factories;

use App\Models\Perfil;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @see https://laravel.com/docs/8.x/database-testing
 * @see https://github.com/fzaninotto/Faker
 */
class PerfilFactory extends Factory
{
    protected $model = Perfil::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $sentence = Str::of($this->faker->unique()->sentence());

        return [
            'nome' => (string) $sentence,
            'slug' => (string) $sentence->slug(),

            'descricao' => random_int(0, 1)
                            ? $this->faker->text(255)
                            : null,
        ];
    }
}
