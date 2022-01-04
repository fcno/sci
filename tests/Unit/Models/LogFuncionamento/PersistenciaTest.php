<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\LogFuncionamento;

test('consegue cadastrar múltiplos logs de funcionamento', function () {
    $amount = 30;

    LogFuncionamento::factory()
                    ->count($amount)
                    ->create();

    expect(LogFuncionamento::count())->toBe($amount);
});

test('campos opcionais corretamente definidos', function ($field) {
    LogFuncionamento::factory()
                    ->create([$field => null]);

    expect(LogFuncionamento::count())->toBe(1);
})->with([
    'ult_import_impressao',
    'ult_import_corporativo',
]);
