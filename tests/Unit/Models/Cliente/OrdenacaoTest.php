<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Cliente;

test('retorna as clientes usando o escopo ascendente por nome', function () {
    $first  = 'Cliente A';
    $second = 'Cliente B';
    $third  = 'Cliente C';

    Cliente::factory()
            ->create(['nome' => $third]);

    Cliente::factory()
            ->create(['nome' => $first]);

    Cliente::factory()
            ->create(['nome' => $second]);

    $clientes = Cliente::sort()
                        ->get();

    expect($clientes->get(0)->nome)->toBe($first)
    ->and($clientes->get(1)->nome)->toBe($second)
    ->and($clientes->get(2)->nome)->toBe($third);
});
