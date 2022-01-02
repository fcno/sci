<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Models\{Cliente, Impressao, Impressora, Lotacao, Servidor, Usuario};
use Illuminate\Database\QueryException;

test('o relacionamento lotação é opcional', function($campo) {
    Impressao::factory()
                ->create([$campo => null]);

    expect(Usuario::count())->toBe(1);
})->with([
    'lotacao_id'
]);

test('os relacionamentos usuário, lotação, cliente, impressora e servidor estão funcionando', function() {
    $usuario = Usuario::factory()
                        ->create();

    $lotacao = Lotacao::factory()
                        ->create();

    $cliente = Cliente::factory()
                        ->create();

    $impressora = Impressora::factory()
                            ->create();

    $servidor = Servidor::factory()
                            ->create();

    $impressao = Impressao::factory()
                            ->for($usuario, 'usuario')
                            ->for($lotacao, 'lotacao')
                            ->for($cliente, 'cliente')
                            ->for($impressora, 'impressora')
                            ->for($servidor, 'servidor')
                            ->create();

    $impressao->load(['usuario', 'lotacao', 'cliente', 'impressora', 'servidor']);

    expect($impressao)
        ->usuario->toBeInstanceOf(Usuario::class)
        ->lotacao->toBeInstanceOf(Lotacao::class)
        ->cliente->toBeInstanceOf(Cliente::class)
        ->impressora->toBeInstanceOf(Impressora::class)
        ->servidor->toBeInstanceOf(Servidor::class);
});

test('lança exceção ao tentar definir relacionamentos inválidos', function($campo, $valor, $msg) {
    expect(

        fn() => Impressao::factory()
                        ->create([$campo => $valor])

    )->toThrow(QueryException::class, $msg);
})->with([
    ['usuario_id',    10,   'Cannot add or update a child row'], //inexistente
    ['usuario_id',    null, 'cannot be null'],                   //campo obrigatório
    ['lotacao_id',    10,   'Cannot add or update a child row'], //inexistente
    ['cliente_id',    10,   'Cannot add or update a child row'], //inexistente
    ['cliente_id',    null, 'cannot be null'],                   //campo obrigatório
    ['impressora_id', 10,   'Cannot add or update a child row'], //inexistente
    ['impressora_id', null, 'cannot be null'],                   //campo obrigatório
    ['servidor_id',   10,   'Cannot add or update a child row'], //inexistente
    ['servidor_id',   null, 'cannot be null']                    //campo obrigatório
]);
