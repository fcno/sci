<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Cargo;
use Illuminate\Support\Str;

test('consegue cadastrar múltiplos cargos', function () {
    $amount = 30;

    Cargo::factory()
            ->count($amount)
            ->create();

    expect(Cargo::count())->toBe($amount);
});

test('nome do cargo em seu tamanho máximo é aceito no cadastro', function () {
    Cargo::factory()
            ->create(['nome' => Str::random(255)]);

    expect(Cargo::count())->toBe(1);
});
