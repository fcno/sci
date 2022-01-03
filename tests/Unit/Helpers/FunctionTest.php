<?php

/**
 * @link https://pestphp.com/docs/
 */

use function App\Helpers\getLogLevels;
use function App\Helpers\stringToArrayAssoc;

test('stringToArrayAssoc retorna null se valores inválidos forem informados', function($keys, $string, $delimitador) {
    expect(stringToArrayAssoc($keys, $string, $delimitador))->toBeNull();
})->with([
    [['nome', 'idade', 'nacionalidade', 'chave_em_excesso'], 'Fábio,18,brasileiro', ','], // qtd chaves incompatível com a string
    [[], 'Fábio,18,brasileiro', ','],                                                     // chaves não informadas (array vazio)
    [['nome', 'idade', 'nacionalidade', 'chave_em_excesso'], '', ','],                    // string vazia
    [['nome', 'idade', 'nacionalidade', 'chave_em_excesso'], 'Fábio,18,brasileiro', '']   // delimitador vazio
]);

test('stringToArrayAssoc explode a string com base no delimitador e retorna um array associativo corretamente', function() {
    $keys = ['nome', 'idade', 'nacionalidade'];
    $string = 'Fábio,18,brasileiro';
    $delimitador = ',';
    $esperado = [
        'nome'          => 'Fábio',
        'idade'         => '18',
        'nacionalidade' => 'brasileiro'
    ];

    expect(stringToArrayAssoc($keys, $string, $delimitador))->toMatchArray($esperado);
});

test('getLogLevels retorna os níveis de log nos termos da PSR-3', function() {

    expect(getLogLevels()->toArray())->toMatchArray([
        "debug"     => 100,
        "info"      => 200,
        "notice"    => 250,
        "warning"   => 300,
        "error"     => 400,
        "critical"  => 500,
        "alert"     => 550,
        "emergency" => 600
    ]);
});


