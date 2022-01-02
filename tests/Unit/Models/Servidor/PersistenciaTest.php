<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Servidor;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplos servidores', function () {
    $qtd = 30;

    Servidor::factory()
            ->count($qtd)
            ->create();

    expect(Servidor::count())->toBe($qtd);
});

test('campo do servidor em seu tamanho máximo é aceito no cadastro', function ($campo, $tamanho) {
    Servidor::factory()
            ->create([$campo => Str::random($tamanho)]);

    expect(Servidor::count())->toBe(1);
})->with([
    ['nome', 255],
]);
