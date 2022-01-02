<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\{Impressao, Servidor, Localidade};

test('o relacionamento n:m com as localidades está funcionando', function() {
    $qtd_localidades = 4;

    Servidor::factory()
            ->has(Localidade::factory()->count($qtd_localidades), 'localidades')
            ->create();

    $servidor = Servidor::with('localidades')->first();

    expect($servidor->localidades->random())->toBeInstanceOf(Localidade::class)
    ->and($servidor->localidades)->toHaveCount($qtd_localidades);
});

test('o relacionamento com as impressões está funcionando', function() {
    $qtd_impressoes = 3;

    Servidor::factory()
            ->has(Impressao::factory()->count($qtd_impressoes), 'impressoes')
            ->create();

    $servidor = Servidor::with('impressoes')->first();

    expect($servidor->impressoes->random())->toBeInstanceOf(Impressao::class)
    ->and($servidor->impressoes)->toHaveCount($qtd_impressoes);
});
