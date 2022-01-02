<?php

namespace Database\Factories;

use App\Models\{Perfil, PerfilPermanente};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @link https://laravel.com/docs/8.x/database-testing
 * @link https://github.com/fzaninotto/Faker
 */
class PerfilPermanenteFactory extends Factory
{
    protected $model = PerfilPermanente::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'cargo_id' => null,
            'funcao_id' => null,
            'lotacao_id' => null,
            'perfil_id' => Perfil::factory()
        ];
    }
}
