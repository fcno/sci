<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Funcao;

test('retorna as funções usando o escopo ascendente por nome', function () {
    $first  = 'Funçao A';
    $second = 'Funçao B';
    $third  = 'Funçao C';

    Funcao::factory()
            ->create(['nome' => $third]);

    Funcao::factory()
            ->create(['nome' => $first]);

    Funcao::factory()
            ->create(['nome' => $second]);

    $funcoes = Funcao::sort()
                        ->get();

    expect($funcoes->get(0)->nome)->toBe($first)
    ->and($funcoes->get(1)->nome)->toBe($second)
    ->and($funcoes->get(2)->nome)->toBe($third);
});
