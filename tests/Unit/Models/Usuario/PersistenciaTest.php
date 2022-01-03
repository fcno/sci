<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Usuario;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplos usuários', function () {
    $amount = 30;

    Usuario::factory()
            ->count($amount)
            ->create();

    expect(Usuario::count())->toBe($amount);
});

test('campo do usuário em seu tamanho máximo é aceito no cadastro', function ($field, $length) {
    Usuario::factory()
            ->create([$field => Str::random($length)]);

    expect(Usuario::count())->toBe(1);
})->with([
    ['nome', 255],
    ['sigla', 20],
]);

test('campos opcionais corretamente definidos', function () {
    Usuario::factory()
            ->create(['nome' => null]);

    expect(Usuario::count())->toBe(1);
});
