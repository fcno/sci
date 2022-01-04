<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Models\Cliente;
use App\Models\Impressao;
use App\Models\Impressora;
use App\Models\Lotacao;
use App\Models\Servidor;
use App\Models\Usuario;
use Illuminate\Database\QueryException;

test('o relacionamento lotação é opcional', function ($field) {
    Impressao::factory()
                ->create([$field => null]);

    expect(Usuario::count())->toBe(1);
})->with([
    'lotacao_id',
]);

test('os relacionamentos usuário, lotação, cliente, impressora e servidor estão funcionando', function () {
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

    Impressao::factory()
                ->for($usuario, 'usuario')
                ->for($lotacao, 'lotacao')
                ->for($cliente, 'cliente')
                ->for($impressora, 'impressora')
                ->for($servidor, 'servidor')
                ->create();

    $impressao = Impressao::with(['usuario', 'lotacao', 'cliente', 'impressora', 'servidor'])
                            ->first();

    expect($impressao->usuario)->toBeInstanceOf(Usuario::class)
    ->and($impressao->lotacao)->toBeInstanceOf(Lotacao::class)
    ->and($impressao->cliente)->toBeInstanceOf(Cliente::class)
    ->and($impressao->impressora)->toBeInstanceOf(Impressora::class)
    ->and($impressao->servidor)->toBeInstanceOf(Servidor::class);
});

test('lança exceção ao tentar definir relacionamentos inválidos', function ($field, $value, $msg) {
    expect(
        fn () => Impressao::factory()
                        ->create([$field => $value])
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
    ['servidor_id',   null, 'cannot be null'],                   //campo obrigatório
]);
