<?php

/**
 * @author Fábio Cassiano <fabiocassiano@jfes.jus.br>
 *
 * @link https://pestphp.com/docs/
 */

use App\Models\{Servidor, Localidade};

test('o relacionamento n:m com os servidores está funcionando', function() {
    $qtd_servidores = 4;

    Localidade::factory()
                ->has(Servidor::factory()->count($qtd_servidores), 'servidores')
                ->create();

    $localidade = Localidade::with('servidores')->first();

    expect($localidade->servidores->random())->toBeInstanceOf(Servidor::class)
    ->and($localidade->servidores)->toHaveCount($qtd_servidores);
});
