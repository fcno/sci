<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Servidor;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

test('lança exceção ao tentar cadastrar servidores em duplicidade, isto é, com nomes iguais', function () {
    expect(
        fn () => Servidor::factory()
                        ->count(2)
                        ->create(['nome' => 'printserver1.example.org'])
    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exceção ao tentar cadastrar servidor com campo inválido', function ($campo, $valor, $msg) {
    expect(
        fn () => Servidor::factory()
                        ->create([$campo => $valor])
    )->toThrow(QueryException::class, $msg);
})->with([
    ['nome',      Str::random(256), 'Data too long for column'], //campo aceita no máximo 255 caracteres
    ['nome',      null,             'cannot be null'],            //campo obrigatório
]);
