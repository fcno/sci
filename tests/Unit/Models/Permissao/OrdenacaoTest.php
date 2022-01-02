<?php

/**
 * @author Fábio Cassiano <fabiocassiano@jfes.jus.br>
 *
 * @link https://pestphp.com/docs/
 */

use App\Models\Permissao;

test('retorna as permissões usando o escopo ascendente por nome', function() {
    $first  = 'Permissão A';
    $second = 'Permissão B';
    $third  = 'Permissão C';

    Permissao::factory()
                ->create(['nome' => $third]);

    Permissao::factory()
                ->create(['nome' => $first]);

    Permissao::factory()
                ->create(['nome' => $second]);

    $permissoes = Permissao::sort()
                                ->get();

    expect($permissoes->get(0)->nome)->toBe($first)
    ->and($permissoes->get(1)->nome)->toBe($second)
    ->and($permissoes->get(2)->nome)->toBe($third);
});
