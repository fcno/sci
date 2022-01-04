<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Lotacao;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplas lotações', function () {
    $amount = 30;

    Lotacao::factory()
            ->count($amount)
            ->create();

    expect(Lotacao::count())->toBe($amount);
});

test('campo da lotação em seu tamanho máximo é aceito no cadastro', function ($field, $length) {
    Lotacao::factory()
            ->create([$field => Str::random($length)]);

    expect(Lotacao::count())->toBe(1);
})->with([
    ['nome', 255],
    ['sigla', 50],
]);
