<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Impressao;
use App\Models\Impressora;

test('o relacionamento com as impressões está funcionando', function () {
    $amount = 3;

    Impressora::factory()
            ->has(Impressao::factory()->count($amount), 'impressoes')
            ->create();

    $impressora = Impressora::with('impressoes')->first();

    expect($impressora->impressoes->random())->toBeInstanceOf(Impressao::class)
    ->and($impressora->impressoes)->toHaveCount($amount);
});
