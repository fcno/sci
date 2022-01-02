<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\{Impressao};
use Illuminate\Support\Str;

test('consegue cadastrar múltiplas impressões', function () {
    $qtd = 30;

    Impressao::factory()
                ->count($qtd)
                ->create();

    expect(Impressao::count())->toBe($qtd);
});

test('nome do arquivo seu tamanho máximo é aceito no cadastro', function () {
    Impressao::factory()
                ->create(['nome_arquivo' => Str::random(260)]);

    expect(Impressao::count())->toBe(1);
});

test('campos opcionais corretamente definidos', function ($campo) {
    Impressao::factory()
                ->create([$campo => null]);

    expect(Impressao::count())->toBe(1);
})->with([
    'nome_arquivo',
    'tamanho_arquivo',
]);
