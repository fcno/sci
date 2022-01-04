<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Cliente;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplos clientes', function () {
    $amount = 30;

    Cliente::factory()
            ->count($amount)
            ->create();

    expect(Cliente::count())->toBe($amount);
});

test('nome do cliente em seu tamanho máximo é aceito no cadastro', function () {
    Cliente::factory()
            ->create(['nome' => Str::random(255)]);

    expect(Cliente::count())->toBe(1);
});
