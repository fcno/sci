<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Permissao;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplas permissões', function () {
    $amount = 30;

    Permissao::factory()
                ->count($amount)
                ->create();

    expect(Permissao::count())->toBe($amount);
});

test('campo da permissão em seu tamanho máximo é aceito no cadastro', function ($field, $length) {
    Permissao::factory()
                ->create([$field => Str::random($length)]);

    expect(Permissao::count())->toBe(1);
})->with([
    ['nome', 255],
    ['slug', 255],
    ['descricao', 400],
]);

test('campos opcionais corretamente definidos', function () {
    Permissao::factory()
                ->create(['descricao' => null]);

    expect(Permissao::count())->toBe(1);
});
