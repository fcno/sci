<?php

/**
 * @author Fábio Cassiano <fabiocassiano@jfes.jus.br>
 *
 * @link https://pestphp.com/docs/
 */

use App\Models\{Perfil, Permissao, Usuario};

test('o relacionamento n:m com as permissões está funcionando', function() {
    $qtd_permissoes = 4;

    Perfil::factory()
            ->has(Permissao::factory()->count($qtd_permissoes), 'permissoes')
            ->create();

    $perfil = Perfil::with('permissoes')->first();

    expect($perfil->permissoes->random())->toBeInstanceOf(Permissao::class)
    ->and($perfil->permissoes)->toHaveCount($qtd_permissoes);
});

test('o relacionamento com os usuários está funcionando', function() {
    $qtd_usuarios = 3;

    Perfil::factory()
            ->has(Usuario::factory()->count($qtd_usuarios), 'usuarios')
            ->create();

    $perfil = Perfil::with('usuarios')->first();

    expect($perfil->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($perfil->usuarios)->toHaveCount($qtd_usuarios);
});
