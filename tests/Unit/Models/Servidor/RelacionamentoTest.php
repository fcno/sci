<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Impressao;
use App\Models\Localidade;
use App\Models\Servidor;

test('o relacionamento n:m com as localidades está funcionando', function () {
    $amount = 4;

    Servidor::factory()
            ->has(Localidade::factory()->count($amount), 'localidades')
            ->create();

    $servidor = Servidor::with('localidades')->first();

    expect($servidor->localidades->random())->toBeInstanceOf(Localidade::class)
    ->and($servidor->localidades)->toHaveCount($amount);
});

test('o relacionamento com as impressões está funcionando', function () {
    $amount = 3;

    Servidor::factory()
            ->has(Impressao::factory()->count($amount), 'impressoes')
            ->create();

    $servidor = Servidor::with('impressoes')->first();

    expect($servidor->impressoes->random())->toBeInstanceOf(Impressao::class)
    ->and($servidor->impressoes)->toHaveCount($amount);
});
