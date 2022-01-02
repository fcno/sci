<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\Servidor;

test('retorna os servidores usando o escopo ascendente por nome', function() {
    $first  = 'Servidor A';
    $second = 'Servidor B';
    $third  = 'Servidor C';

    Servidor::factory()
            ->create(['nome' => $third]);

    Servidor::factory()
            ->create(['nome' => $first]);

    Servidor::factory()
            ->create(['nome' => $second]);

    $servidores = Servidor::sort()
                            ->get();

    expect($servidores->get(0)->nome)->toBe($first)
    ->and($servidores->get(1)->nome)->toBe($second)
    ->and($servidores->get(2)->nome)->toBe($third);
});
