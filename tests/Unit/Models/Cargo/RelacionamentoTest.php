<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Cargo;
use App\Models\Usuario;

test('o relacionamento com os usuários está funcionando', function () {
    $qtd_usuarios = 3;

    Cargo::factory()
            ->has(Usuario::factory()->count($qtd_usuarios), 'usuarios')
            ->create();

    $cargo = Cargo::with('usuarios')->first();

    expect($cargo->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($cargo->usuarios)->toHaveCount($qtd_usuarios);
});
