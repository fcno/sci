<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Perfil;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

test('lança exceção ao tentar cadastrar perfis em duplicidade, isto é, com nomes ou slugs iguais', function () {
    expect(
        fn () => Perfil::factory()
                        ->count(2)
                        ->create(['nome' => 'Usuário Padrão'])
    )->toThrow(QueryException::class, 'Duplicate entry');

    expect(
        fn () => Perfil::factory()
                        ->count(2)
                        ->create(['slug' => 'usuario-padrao'])
    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exceção ao tentar cadastrar perfil com campo inválido', function ($field, $value, $msg) {
    expect(
        fn () => Perfil::factory()
                        ->create([$field => $value])
    )->toThrow(QueryException::class, $msg);
})->with([
    ['nome',      Str::random(256), 'Data too long for column'], //campo aceita no máximo 255 caracteres
    ['nome',      null,             'cannot be null'],           //campo obrigatório
    ['slug',      Str::random(256), 'Data too long for column'], //campo aceita no máximo 255 caracteres
    ['slug',      null,             'cannot be null'],           //campo obrigatório
    ['descricao', Str::random(401), 'Data too long for column'], //campo aceita no máximo 400 caracteres
]);
