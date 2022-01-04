<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\LogFuncionamento;
use Illuminate\Database\QueryException;

test('lança exceção ao tentar cadastrar logs de funcionamento em duplicidade, isto é, com ids iguais', function () {
    expect(
        fn () => LogFuncionamento::factory()
                                ->count(2)
                                ->create(['id' => 10])
    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exceção ao tentar cadastrar log de funcionamento com campo inválido', function ($field, $value, $msg) {
    expect(
        fn () => LogFuncionamento::factory()
                        ->create([$field => $value])
    )->toThrow(QueryException::class, $msg);
})->with([
    ['ult_import_impressao',   '2000-02-31', 'Incorrect date value'], //data inexistente
    ['ult_import_impressao',   'texto',      'Incorrect date value'], //valor não conversível em data
    ['ult_import_corporativo', '2000-02-31', 'Incorrect date value'], //data inexistente
    ['ult_import_corporativo', 'texto',      'Incorrect date value'], //valor não conversível em data
]);
