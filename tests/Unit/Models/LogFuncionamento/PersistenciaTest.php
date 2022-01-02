<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\LogFuncionamento;

test('consegue cadastrar múltiplos logs de funcionamento', function() {
    $qtd = 30;

    LogFuncionamento::factory()
                    ->count($qtd)
                    ->create();

    expect(LogFuncionamento::count())->toBe($qtd);
});

test('campos opcionais corretamente definidos', function($campo) {
    LogFuncionamento::factory()
                    ->create([$campo => null]);

    expect(LogFuncionamento::count())->toBe(1);
})->with([
    'ult_import_impressao',
    'ult_import_corporativo'
]);
