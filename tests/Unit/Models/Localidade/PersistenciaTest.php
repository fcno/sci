<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Localidade;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplas localidades', function () {
    $amount = 30;

    Localidade::factory()
                ->count($amount)
                ->create();

    expect(Localidade::count())->toBe($amount);
});

test('campo da localidade em seu tamanho máximo é aceito no cadastro', function ($amount, $length) {
    Localidade::factory()
                ->create([$amount => Str::random($length)]);

    expect(Localidade::count())->toBe(1);
})->with([
    ['nome', 255],
]);
