<?php

/**
 * @author Fábio Cassiano <fabiocassiano@jfes.jus.br>
 *
 * @link https://pestphp.com/docs/
 */

use App\Models\Usuario;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplos usuários', function() {
    $qtd = 30;

    Usuario::factory()
            ->count($qtd)
            ->create();

    expect(Usuario::count())->toBe($qtd);
});

test('campo do usuário em seu tamanho máximo é aceito no cadastro', function($campo, $tamanho) {
    Usuario::factory()
            ->create([$campo => Str::random($tamanho)]);

    expect(Usuario::count())->toBe(1);
})->with([
    ['nome', 255],
    ['sigla', 20]
]);

test('campos opcionais corretamente definidos', function() {
    Usuario::factory()
            ->create(['nome' => null]);

    expect(Usuario::count())->toBe(1);
});
