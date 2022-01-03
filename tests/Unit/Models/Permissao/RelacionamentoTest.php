<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Perfil;
use App\Models\Permissao;

test('o relacionamento n:m com os perfis está funcionando', function () {
    $amount = 4;

    Permissao::factory()
                ->has(Perfil::factory()->count($amount), 'perfis')
                ->create();

    $permissao = Permissao::with('perfis')->first();

    expect($permissao->perfis->random())->toBeInstanceOf(Perfil::class)
    ->and($permissao->perfis)->toHaveCount($amount);
});
