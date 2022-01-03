<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Perfil;
use App\Models\Permissao;
use App\Models\Usuario;

test('o relacionamento n:m com as permissões está funcionando', function () {
    $amount = 4;

    Perfil::factory()
            ->has(Permissao::factory()->count($amount), 'permissoes')
            ->create();

    $perfil = Perfil::with('permissoes')->first();

    expect($perfil->permissoes->random())->toBeInstanceOf(Permissao::class)
    ->and($perfil->permissoes)->toHaveCount($amount);
});

test('o relacionamento com os usuários está funcionando', function () {
    $amount = 3;

    Perfil::factory()
            ->has(Usuario::factory()->count($amount), 'usuarios')
            ->create();

    $perfil = Perfil::with('usuarios')->first();

    expect($perfil->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($perfil->usuarios)->toHaveCount($amount);
});
