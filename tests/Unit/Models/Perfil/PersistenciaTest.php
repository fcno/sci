<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\Perfil;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplos perfis', function() {
    $qtd = 30;

    Perfil::factory()
            ->count($qtd)
            ->create();

    expect(Perfil::count())->toBe($qtd);
});

test('campo do perfil em seu tamanho máximo é aceito no cadastro', function($campo, $tamanho) {
    Perfil::factory()
            ->create([$campo => Str::random($tamanho)]);

    expect(Perfil::count())->toBe(1);
})->with([
    ['nome', 255],
    ['slug', 255],
    ['descricao', 400]
]);

test('campos opcionais corretamente definidos', function() {
    Perfil::factory()
            ->create(['descricao' => null]);

    expect(Perfil::count())->toBe(1);
});
