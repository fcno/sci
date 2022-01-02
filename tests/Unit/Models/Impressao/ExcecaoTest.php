<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Cliente;
use App\Models\Impressao;
use App\Models\Impressora;
use App\Models\Servidor;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

test('lança exceção ao tentar cadastrar impressões em duplicidade, isto é, com data, hora, usuário e impressora iguais', function () {
    expect(
        fn () => Impressao::factory()
                            ->for(Usuario::factory(), 'usuario')
                            ->for(Impressora::factory(), 'impressora')
                            ->for(Cliente::factory(), 'cliente')
                            ->for(Servidor::factory(), 'servidor')
                            ->count(2)
                            ->create([
                                'data' => '1979-08-21',
                                'hora' => '10:30:59',
                            ])
    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exceção ao tentar cadastrar impressão com campo inválido', function ($campo, $valor, $msg) {
    expect(
        fn () => Impressao::factory()
                            ->create([$campo => $valor])
    )->toThrow(QueryException::class, $msg);
})->with([
    ['data',            '2000-02-31',     'Incorrect date value'],     //data inexistente
    ['data',            'texto',          'Incorrect date value'],     //valor não conversível em data
    ['data',            null,             'cannot be null'],           //campo obrigatório
    ['hora',            '10:59:60',       'Incorrect time value'],     //hora inexistente
    ['hora',            null,             'cannot be null'],           //campo obrigatório
    ['hora',            'texto',          'Incorrect time value'],     //valor não conversível em hora
    ['nome_arquivo',    Str::random(261), 'Data too long for column'], //campo aceita no máximo 261 caracteres
    ['tamanho_arquivo', 'texto',          'Incorrect integer value'],  //valor não conversível em inteiro
    ['qtd_pagina',      'texto',          'Incorrect integer value'],  //valor não conversível em inteiro
    ['qtd_pagina',      null,             'cannot be null'],           //campo obrigatório
    ['qtd_copia',       'texto',          'Incorrect integer value'],  //valor não conversível em inteiro
    ['qtd_copia',       null,             'cannot be null'],            //campo obrigatório
]);
