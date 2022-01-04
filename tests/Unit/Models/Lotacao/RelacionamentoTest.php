<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Impressao;
use App\Models\Lotacao;
use App\Models\Usuario;
use Illuminate\Database\QueryException;

test('lança exceção ao tentar definir relacionamento com lotação pai que não existe', function () {
    expect(
        fn () => Lotacao::factory()
                        ->create(['lotacao_pai' => 10])
    )->toThrow(QueryException::class, 'Cannot add or update a child row');
});

test('a lotação pai é opcional na lotação', function () {
    Lotacao::factory()
            ->create(['lotacao_pai' => null]);

    expect(Lotacao::count())->toBe(1);
});

test('os relacionamentos pai e filha estão funcionando na lotação', function () {
    $amount_child = 3;
    $id_parent = 1;

    Lotacao::factory()
            ->create(['id' => $id_parent]);

    Lotacao::factory()
            ->count($amount_child)
            ->create(['lotacao_pai' => $id_parent]);

    $pai = Lotacao::with(['lotacoesFilha', 'lotacaoPai'])
                    ->find($id_parent);
    $filha = Lotacao::with(['lotacoesFilha', 'lotacaoPai'])
                    ->where('lotacao_pai', '=', $id_parent)
                    ->get()
                    ->random();

    expect($pai->lotacoesFilha)->toHaveCount($amount_child)
    ->and($pai->lotacaoPai)->toBeNull()
    ->and($filha->lotacaoPai->id)->toBe($pai->id)
    ->and($filha->lotacoesFilha)->toHaveCount(0);
});

test('o relacionamento com os usuários e as impressões está funcionando', function () {
    $amount = 3;

    Lotacao::factory()
            ->has(Usuario::factory()->count($amount), 'usuarios')
            ->has(Impressao::factory()->count($amount), 'impressoes')
            ->create();

    $lotacao = Lotacao::with(['usuarios', 'impressoes'])->first();

    expect($lotacao->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($lotacao->usuarios)->toHaveCount($amount)
    ->and($lotacao->impressoes->random())->toBeInstanceOf(Impressao::class)
    ->and($lotacao->impressoes)->toHaveCount($amount);
});
