<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Cargo;
use App\Models\Usuario;

test('o relacionamento com os usuários está funcionando', function () {
    $amount = 3;

    Cargo::factory()
            ->has(Usuario::factory()->count($amount), 'usuarios')
            ->create();

    $cargo = Cargo::with('usuarios')->first();

    expect($cargo->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($cargo->usuarios)->toHaveCount($amount);
});
