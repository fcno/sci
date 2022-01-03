<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Monolog\Logger;

if (!function_exists('App\Helpers\stringToArrayAssoc')) {

    /**
     * Divide uma string com base no delimitador informado e a retorna como um
     * array associativo usando as chaves para cada valor extraído da string.
     *
     * Os valores extraídos devem ser compatíveis numericamente com a
     * quantidade de chaves informadas, caso contrário retornará nulo.
     * Também retornará nulo se algum dos parâmetros for um valor false para o
     * php
     *
     * @param array   $keys       Chaves que serão usadas para indexar o
     * array de retorno
     * @param string  $str          string que será explodida
     * @param string  $delimiter  delimitador para a explodir a string
     *
     * @return array|null Ex.: `['key' => 'value', ...]`
     *
     * @link https://www.php.net/manual/en/language.types.boolean.php
     */
    function stringToArrayAssoc(array $keys, string $str, string $delimiter): ?array
    {
        if (! $keys || ! $str || ! $delimiter) {
            return null;
        }

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

if (!function_exists('App\Helpers\getLogLevels')) {

    /**
     * Níveis de log nos termos da PSR-3.
     *
     * @return \Illuminate\Support\Collection chave (string nome do nível) e
     * valor (int código do nível)
     *
     * @link https://www.php-fig.org/psr/psr-3/
     */
    function getLogLevels(): Collection
    {
        return collect(
            Logger::getLevels()
        );
    }
}
