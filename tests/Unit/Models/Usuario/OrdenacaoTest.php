<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Usuario;

test('retorna os usuários usando o escopo ascendente por nome', function () {
    $first = 'Perfil A';
    $second = 'Perfil B';
    $third = 'Perfil C';

    Usuario::factory()
            ->create(['nome' => $third]);

    Usuario::factory()
            ->create(['nome' => $first]);

    Usuario::factory()
            ->create(['nome' => $second]);

    $usuarios = Usuario::sort()
                        ->get();

    expect($usuarios->get(0)->nome)->toBe($first)
    ->and($usuarios->get(1)->nome)->toBe($second)
    ->and($usuarios->get(2)->nome)->toBe($third);
});
