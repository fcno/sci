<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Funcao;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplas funções', function () {
    $qtd = 30;

    Funcao::factory()
            ->count($qtd)
            ->create();

    expect(Funcao::count())->toBe($qtd);
});

test('nome da função em seu tamanho máximo é aceito no cadastro', function () {
    Funcao::factory()
            ->create(['nome' => Str::random(255)]);

    expect(Funcao::count())->toBe(1);
});
