<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Impressora;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplas impressoras', function () {
    $amount = 30;

    Impressora::factory()
                ->count($amount)
                ->create();

    expect(Impressora::count())->toBe($amount);
});

test('nome da impressora em seu tamanho máximo é aceito no cadastro', function () {
    Impressora::factory()
                ->create(['nome' => Str::random(255)]);

    expect(Impressora::count())->toBe(1);
});
