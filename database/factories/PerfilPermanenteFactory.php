<?php

namespace Database\Factories;

use App\Models\Perfil;
use App\Models\PerfilPermanente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @see https://laravel.com/docs/8.x/database-testing
 * @see https://github.com/fzaninotto/Faker
 */
class PerfilPermanenteFactory extends Factory
{
    protected $model = PerfilPermanente::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'cargo_id' => null,
            'funcao_id' => null,
            'lotacao_id' => null,
            'perfil_id' => Perfil::factory(),
        ];
    }
}
