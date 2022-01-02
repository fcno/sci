<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Lotacao;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplas lotações', function () {
    $qtd = 30;

    Lotacao::factory()
            ->count($qtd)
            ->create();

    expect(Lotacao::count())->toBe($qtd);
});

test('campo da lotação em seu tamanho máximo é aceito no cadastro', function ($campo, $tamanho) {
    Lotacao::factory()
            ->create([$campo => Str::random($tamanho)]);

    expect(Lotacao::count())->toBe(1);
})->with([
    ['nome', 255],
    ['sigla', 50],
]);
