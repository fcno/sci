<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Perfil;

test('retorna os perfis usando o escopo ascendente por nome', function () {
    $first  = 'Perfil A';
    $second = 'Perfil B';
    $third  = 'Perfil C';

    Perfil::factory()
            ->create(['nome' => $third]);

    Perfil::factory()
            ->create(['nome' => $first]);

    Perfil::factory()
            ->create(['nome' => $second]);

    $perfis = Perfil::sort()
                        ->get();

    expect($perfis->get(0)->nome)->toBe($first)
    ->and($perfis->get(1)->nome)->toBe($second)
    ->and($perfis->get(2)->nome)->toBe($third);
});
