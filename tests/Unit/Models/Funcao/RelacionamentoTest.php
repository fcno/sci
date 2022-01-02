<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\{Funcao, Usuario};

test('o relacionamento com os usuários está funcionando', function() {
    $qtd_usuarios = 3;

    Funcao::factory()
            ->has(Usuario::factory()->count($qtd_usuarios), 'usuarios')
            ->create();

    $funcao = Funcao::with('usuarios')->first();

    expect($funcao->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($funcao->usuarios)->toHaveCount($qtd_usuarios);
});
