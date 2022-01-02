<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\Permissao;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

test('lança exceção ao tentar cadastrar permissões em duplicidade, isto é, com nomes ou slugs iguais', function() {
    expect(

        fn() => Permissao::factory()
                            ->count(2)
                            ->create(['nome' => 'Relatório Alfa'])

    )->toThrow(QueryException::class, 'Duplicate entry');


    expect(

        fn() => Permissao::factory()
                            ->count(2)
                            ->create(['slug' => 'relatorio-alfa'])

    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exceção ao tentar cadastrar permissões com campo inválido', function($campo, $valor) {
    expect(

        fn() => Permissao::factory()
                            ->create([$campo => $valor])

    )->toThrow(QueryException::class);
})->with([
    ['nome',      Str::random(256), 'Data too long for column'], //campo aceita no máximo 255 caracteres
    ['nome',      null,             'cannot be null'],           //campo obrigatório
    ['slug',      Str::random(256), 'Data too long for column'], //campo aceita no máximo 255 caracteres
    ['slug',      null,             'cannot be null'],           //campo obrigatório
    ['descricao', Str::random(401), 'Data too long for column']  //campo aceita no máximo 400 caracteres
]);
