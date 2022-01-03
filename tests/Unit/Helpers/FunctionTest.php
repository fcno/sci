<?php

/**
 * @link https://pestphp.com/docs/
 */

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
