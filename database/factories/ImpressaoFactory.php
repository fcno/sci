<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Impressao;
use App\Models\Impressora;
use App\Models\Servidor;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @see https://laravel.com/docs/8.x/database-testing
 * @see https://github.com/fzaninotto/Faker
 */
class ImpressaoFactory extends Factory
{
    protected $model = Impressao::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::factory(),
            'lotacao_id' => null,
            'cliente_id' => Cliente::factory(),
            'impressora_id' => Impressora::factory(),
            'servidor_id' => Servidor::factory(),
            'data' => $this
                        ->faker
                        ->dateTimeBetween()
                        ->format('Y-m-d'),

            'hora' => $this->faker->time(),

            'nome_arquivo' => random_int(0, 1)
                                ? $this->faker->word().'.txt'
                                : null,

            'tamanho_arquivo' => random_int(0, 1)
                                    ? $this->faker->randomNumber(3)
                                    : null,

            'qtd_pagina' => random_int(1, 100),
            'qtd_copia' => random_int(1, 20),
        ];
    }
}
