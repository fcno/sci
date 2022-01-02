<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\{Cliente, Impressao};

test('o relacionamento com as impressões está funcionando', function() {
    $qtd_impressoes = 3;

    Cliente::factory()
            ->has(Impressao::factory()->count($qtd_impressoes), 'impressoes')
            ->create();

    $cliente = Cliente::with('impressoes')->first();

    expect($cliente->impressoes->random())->toBeInstanceOf(Impressao::class)
    ->and($cliente->impressoes)->toHaveCount($qtd_impressoes);
});
