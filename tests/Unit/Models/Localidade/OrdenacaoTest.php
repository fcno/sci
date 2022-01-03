<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Localidade;

test('retorna as localidades usando o escopo ascendente por nome', function () {
    $first  = 'Localidade A';
    $second = 'Localidade B';
    $third  = 'Localidade C';

    Localidade::factory()
                ->create(['nome' => $third]);

    Localidade::factory()
                ->create(['nome' => $first]);

    Localidade::factory()
                ->create(['nome' => $second]);

    $localidades = Localidade::sort()
                                ->get();

    expect($localidades->get(0)->nome)->toBe($first)
    ->and($localidades->get(1)->nome)->toBe($second)
    ->and($localidades->get(2)->nome)->toBe($third);
});
