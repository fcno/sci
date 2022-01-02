<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\{Cargo, Funcao, Lotacao, Perfil, PerfilPermanente};
use Illuminate\Database\QueryException;

test('lança exceção ao tentar cadastrar perfis permanentes em duplicidade, isto é, relacionados simultamente ao mesmo cargo, função e lotação', function() {
    expect(

        fn() => PerfilPermanente::factory()
                                ->for(Cargo::factory(), 'cargo')
                                ->for(Funcao::factory(), 'funcao')
                                ->for(Lotacao::factory(), 'lotacao')
                                ->count(2)
                                ->create()

    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('os relacionamentos cargo, função e lotação são opcionais', function($campo) {
    PerfilPermanente::factory()
                        ->create([$campo => null]);

    expect(PerfilPermanente::count())->toBe(1);
})->with([
    'cargo_id',
    'funcao_id',
    'lotacao_id'
]);

test('lança exceção ao tentar definir relacionamentos inválidos', function($campo, $valor, $msg) {
    expect(

        fn() => PerfilPermanente::factory()
                                ->create([$campo => $valor])

    )->toThrow(QueryException::class, $msg);
})->with([
    ['cargo_id',   10,   'Cannot add or update a child row'], //inexistente
    ['funcao_id',  10,   'Cannot add or update a child row'], //inexistente
    ['lotacao_id', 10,   'Cannot add or update a child row'], //inexistente
    ['perfil_id',  null, 'cannot be null'],                   //campo obrigatório
    ['perfil_id',  10,   'Cannot add or update a child row']  //inexistente
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

    PerfilPermanente::factory()
                    ->for($cargo, 'cargo')
                    ->for($funcao, 'funcao')
                    ->for($lotacao, 'lotacao')
                    ->for($perfil, 'perfil')
                    ->create();

    $perfil_permanente = PerfilPermanente::with(['cargo', 'funcao', 'lotacao', 'perfil'])
                                            ->first();

    expect($perfil_permanente->cargo)->toBeInstanceOf(Cargo::class)
    ->and($perfil_permanente->funcao)->toBeInstanceOf(Funcao::class)
    ->and($perfil_permanente->lotacao)->toBeInstanceOf(Lotacao::class)
    ->and($perfil_permanente->perfil)->toBeInstanceOf(Perfil::class);
});
