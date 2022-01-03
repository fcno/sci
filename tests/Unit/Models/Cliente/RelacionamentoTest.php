<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Cliente;
use App\Models\Impressao;

test('o relacionamento com as impressões está funcionando', function () {
    $amount = 3;

    Cliente::factory()
            ->has(Impressao::factory()->count($amount), 'impressoes')
            ->create();

    $cliente = Cliente::with('impressoes')->first();

    expect($cliente->impressoes->random())->toBeInstanceOf(Impressao::class)
    ->and($cliente->impressoes)->toHaveCount($amount);
});
