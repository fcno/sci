<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\PerfilPermanente;

test('retorna os perfis permanentes usando o escopo ascendente por id', function() {
    $first  = 10;
    $second = 30;
    $third  = 50;

    PerfilPermanente::factory()
                        ->create(['id' => $third]);

    PerfilPermanente::factory()
                        ->create(['id' => $first]);

    PerfilPermanente::factory()
                        ->create(['id' => $second]);

    $perfis_permanentes = PerfilPermanente::sort()
                                            ->get();

    expect($perfis_permanentes->get(0)->id)->toBe($first)
    ->and($perfis_permanentes->get(1)->id)->toBe($second)
    ->and($perfis_permanentes->get(2)->id)->toBe($third);
});
