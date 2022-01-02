<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Perfil;
use App\Models\Permissao;

test('o relacionamento n:m com os perfis está funcionando', function () {
    $qtd_perfis = 4;

    Permissao::factory()
                ->has(Perfil::factory()->count($qtd_perfis), 'perfis')
                ->create();

    $permissao = Permissao::with('perfis')->first();

    expect($permissao->perfis->random())->toBeInstanceOf(Perfil::class)
    ->and($permissao->perfis)->toHaveCount($qtd_perfis);
});
