<?php

/**
 * @author Fábio Cassiano <fabiocassiano@jfes.jus.br>
 *
 * @link https://pestphp.com/docs/
 */

use App\Models\{Cargo, Funcao, Impressao, Lotacao, Perfil, Usuario};
use Illuminate\Database\QueryException;

test('os relacionamentos cargo, função, lotação e perfil são opcionais', function($campo) {
    Usuario::factory()
            ->create([$campo => null]);

    expect(Usuario::count())->toBe(1);
})->with([
    'cargo_id',
    'funcao_id',
    'lotacao_id',
    'perfil_id'
]);

test('os relacionamentos cargo, função, lotação e perfil estão funcionando', function() {
    $cargo = Cargo::factory()
                    ->create();
    $funcao = Funcao::factory()
                    ->create();
    $lotacao = Lotacao::factory()
                        ->create();
    $perfil = Perfil::factory()
                        ->create();

    $usuario = Usuario::factory()
                        ->for($cargo, 'cargo')
                        ->for($funcao, 'funcao')
                        ->for($lotacao, 'lotacao')
                        ->for($perfil, 'perfil')
                        ->create();

    $usuario->load(['cargo', 'funcao', 'lotacao', 'perfil']);

    expect($usuario)
        ->cargo->toBeInstanceOf(Cargo::class)
        ->funcao->toBeInstanceOf(Funcao::class)
        ->lotacao->toBeInstanceOf(Lotacao::class)
        ->perfil->toBeInstanceOf(Perfil::class);
});

test('lança exceção ao tentar definir relacionamentos inválidos', function($campo, $valor, $msg) {
    expect(

        fn() => Usuario::factory()
                        ->create([$campo => $valor])

    )->toThrow(QueryException::class, $msg);
})->with([
    ['cargo_id',   10, 'Cannot add or update a child row'], //inexistente
    ['funcao_id',  10, 'Cannot add or update a child row'], //inexistente
    ['lotacao_id', 10, 'Cannot add or update a child row'], //inexistente
    ['perfil_id',  10, 'Cannot add or update a child row']  //inexistente
]);

test('o relacionamento com as impressões está funcionando', function() {
    $qtd_impressoes = 3;

    Usuario::factory()
            ->has(Impressao::factory()->count($qtd_impressoes), 'impressoes')
            ->create();

    $usuario = Usuario::with('impressoes')->first();

    expect($usuario->impressoes->random())->toBeInstanceOf(Impressao::class)
    ->and($usuario->impressoes)->toHaveCount($qtd_impressoes);
});
