<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Localidade;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplas localidades', function () {
    $qtd = 30;

    Localidade::factory()
                ->count($qtd)
                ->create();

    expect(Localidade::count())->toBe($qtd);
});

test('campo da localidade em seu tamanho máximo é aceito no cadastro', function ($campo, $tamanho) {
    Localidade::factory()
                ->create([$campo => Str::random($tamanho)]);

    expect(Localidade::count())->toBe(1);
})->with([
    ['nome', 255],
]);
