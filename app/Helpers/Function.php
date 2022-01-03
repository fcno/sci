<?php

namespace App\Helpers;

if (!function_exists('App\Helpers\stringToArrayAssoc')) {

    /**
     * Divide uma string com base no delimitador informado e a retorna como um
     * array associativo usando as chaves para cada valor extraído da string.
     *
     * Os valores extraídos devem ser compatíveis numericamente com a
     * quantidade de chaves informadas, caso contrário retornará nulo.
     *
     * @param array   $keys       Chaves que serão usadas para indexar o
     * array de retorno
     * @param string  $str          string que será explodida
     * @param string  $delimiter  delimitador para a explodir a string
     *
     * @return array|null Ex.: `['key' => 'value', ...]`
     */
    function stringToArrayAssoc(array $keys, string $str, string $delimiter): ?array
    {
        try {
            return
                array_combine(
                    $keys,
                    explode($delimiter, $str)
                );
        } catch (\Throwable $exception) {
            return null;
        }
    }
}
