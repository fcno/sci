<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\PerfilPermanente;

test('consegue cadastrar múltiplos perfis permanentes', function () {
    $qtd = 30;

    PerfilPermanente::factory()
                    ->count($qtd)
                    ->create();

    expect(PerfilPermanente::count())->toBe($qtd);
});
