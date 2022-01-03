<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Perfil;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplos perfis', function () {
    $amount = 30;

    Perfil::factory()
            ->count($amount)
            ->create();

    expect(Perfil::count())->toBe($amount);
});

test('campo do perfil em seu tamanho máximo é aceito no cadastro', function ($field, $length) {
    Perfil::factory()
            ->create([$field => Str::random($length)]);

    expect(Perfil::count())->toBe(1);
})->with([
    ['nome', 255],
    ['slug', 255],
    ['descricao', 400],
]);

test('campos opcionais corretamente definidos', function () {
    Perfil::factory()
            ->create(['descricao' => null]);

    expect(Perfil::count())->toBe(1);
});
