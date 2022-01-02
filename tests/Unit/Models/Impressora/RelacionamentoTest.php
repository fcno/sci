<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\{Impressao, Impressora};

test('o relacionamento com as impressões está funcionando', function() {
    $qtd_impressoes = 3;

    Impressora::factory()
            ->has(Impressao::factory()->count($qtd_impressoes), 'impressoes')
            ->create();

    $impressora = Impressora::with('impressoes')->first();

    expect($impressora->impressoes->random())->toBeInstanceOf(Impressao::class)
    ->and($impressora->impressoes)->toHaveCount($qtd_impressoes);
});
