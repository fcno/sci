<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\Cliente;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplos clientes', function() {
    $qtd = 30;

    Cliente::factory()
            ->count($qtd)
            ->create();

    expect(Cliente::count())->toBe($qtd);
});

test('nome do cliente em seu tamanho máximo é aceito no cadastro', function() {
    Cliente::factory()
            ->create(['nome' => Str::random(255)]);

    expect(Cliente::count())->toBe(1);
});
