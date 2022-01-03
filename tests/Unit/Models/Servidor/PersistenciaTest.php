<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Servidor;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplos servidores', function () {
    $amount = 30;

    Servidor::factory()
            ->count($amount)
            ->create();

    expect(Servidor::count())->toBe($amount);
});

test('campo do servidor em seu tamanho máximo é aceito no cadastro', function ($field, $length) {
    Servidor::factory()
            ->create([$field => Str::random($length)]);

    expect(Servidor::count())->toBe(1);
})->with([
    ['nome', 255],
]);
