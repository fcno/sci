<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Impressora;

test('retorna as impressoras usando o escopo ascendente por nome', function () {
    $first = 'Impressora A';
    $second = 'Impressora B';
    $third = 'Impressora C';

    Impressora::factory()
                ->create(['nome' => $third]);

    Impressora::factory()
                ->create(['nome' => $first]);

    Impressora::factory()
                ->create(['nome' => $second]);

    $impressoras = Impressora::sort()
                                ->get();

    expect($impressoras->get(0)->nome)->toBe($first)
    ->and($impressoras->get(1)->nome)->toBe($second)
    ->and($impressoras->get(2)->nome)->toBe($third);
});
