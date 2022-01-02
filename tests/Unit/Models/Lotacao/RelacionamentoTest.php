<?php

/**
 * @author Fábio Cassiano <fabiocassiano@jfes.jus.br>
 *
 * @link https://pestphp.com/docs/
 */

use App\Models\{Impressao, Lotacao, Usuario};
use Illuminate\Database\QueryException;

test('lança exceção ao tentar definir relacionamento com lotação pai que não existe', function() {
    expect(

        fn() => Lotacao::factory()
                            ->create(['lotacao_pai' => 10])

    )->toThrow(QueryException::class, 'Cannot add or update a child row');
});

test('a lotação pai é opcional na lotação', function() {
    Lotacao::factory()
                ->create(['lotacao_pai' => null]);

    expect(Lotacao::count())->toBe(1);
});

test('os relacionamentos pai e filha estão funcionando na lotação', function() {
    $qtd_filhas = 3;

    $pai = Lotacao::factory()
                    ->create();

    $filhas = Lotacao::factory()
                        ->count($qtd_filhas)
                        ->for($pai, 'lotacaoPai')
                        ->create();

    $pai->load(['lotacoesFilha', 'lotacaoPai']);
    $filha = $filhas->random()->load(['lotacoesFilha', 'lotacaoPai']);

    expect($pai->lotacoesFilha)->toHaveCount($qtd_filhas)
    ->and($pai->lotacaoPai)->toBeNull()
    ->and($filha->lotacaoPai->id)->toBe($pai->id)
    ->and($filha->lotacoesFilha)->toHaveCount(0);
});

test('o relacionamento com os usuários e as impressões está funcionando', function() {
    $qtd = 3;

    Lotacao::factory()
            ->has(Usuario::factory()->count($qtd), 'usuarios')
            ->has(Impressao::factory()->count($qtd), 'impressoes')
            ->create();

    $lotacao = Lotacao::with(['usuarios', 'impressoes'])->first();

    expect($lotacao->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($lotacao->usuarios)->toHaveCount($qtd)
    ->and($lotacao->impressoes->random())->toBeInstanceOf(Impressao::class)
    ->and($lotacao->impressoes)->toHaveCount($qtd);
});
