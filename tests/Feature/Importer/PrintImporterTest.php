<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Events\ExceptionEvent;
use App\Events\FailureEvent;
use App\Importer\PrintImporter;
use App\Models\Cargo;
use App\Models\Cliente;
use App\Models\Funcao;
use App\Models\Impressao;
use App\Models\Impressora;
use App\Models\Lotacao;
use App\Models\Servidor;
use App\Models\Usuario;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

test('o importador retorna o objeto da classe corretamente no método make', function () {
    expect(PrintImporter::make())->toBeInstanceOf(PrintImporter::class);
});

test('não importa nada da string de impressão se ela estiver completa, isto é, com todos os campos presentes (mesmo que vazios)', function () {
    // sem a delimitação para o último parâmetro (qtd de cópias)
    $print = 'server.dominio.org.br╡01/06/2020╡07:35:35╡documento de teste.pdf╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡2567217╡1';

    PrintImporter::make()->run($print);

    expect(Impressao::count())->toBe(0)
    ->and(Servidor::count())->toBe(0)
    ->and(Usuario::count())->toBe(0)
    ->and(Cargo::count())->toBe(0)
    ->and(Funcao::count())->toBe(0)
    ->and(Lotacao::count())->toBe(0)
    ->and(Cliente::count())->toBe(0)
    ->and(Impressora::count())->toBe(0);
});

test('dispara o evento falha se o nome do servidor for inválido para importação', function ($servidor) {
    $print = "{$servidor}╡01/06/2020╡07:35:35╡documento de teste.pdf╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡2567217╡1╡1";

    Event::fake();

    PrintImporter::make()->run($print);

    Event::assertDispatched(FailureEvent::class);
    expect(Impressao::get())->toBeEmpty();
})->with([
    Str::random(256), // campo aceita no máximo 255 caracteres
    null,             // campo obrigatório
]);

test('dispara o evento falha se a sigla do usuário for inválida para importação', function ($sigla) {
    $print = "server.dominio.gov.br╡01/06/2020╡07:35:35╡documento de teste.pdf╡{$sigla}╡2021╡╡╡CPU-10000╡IMP-123╡2567217╡1╡1";

    Event::fake();

    PrintImporter::make()->run($print);

    Event::assertDispatched(FailureEvent::class);
    expect(Impressao::get())->toBeEmpty();
})->with([
    Str::random(21), // campo aceita no máximo 20 caracteres
    null,            // campo obrigatório
]);

test('dispara o evento falha se o id do setor (lotação) responsável pela impressão for inválido para importação', function ($lotacao) {
    $print = "server.dominio.gov.br╡01/06/2020╡07:35:35╡documento de teste.pdf╡jesxx╡2021╡{$lotacao}╡╡CPU-10000╡IMP-123╡2567217╡1╡1";

    Event::fake();

    PrintImporter::make()->run($print);

    Event::assertDispatched(FailureEvent::class);
    expect(Impressao::get())->toBeEmpty();
})->with([
    -1, // precisa ser maior ou igual a um
    10, // inexistente
]);

test('o id do setor (lotação) é opcional', function () {
    $lotacao = null;

    $print = "server.dominio.gov.br╡01/06/2020╡07:35:35╡arquivo.pdf╡jesxxx╡2021╡{$lotacao}╡╡CPU-10000╡IMP-123╡2567217╡1╡1";

    PrintImporter::make()->run($print);

    expect(Impressao::get())->toHaveCount(1);
});

test('dispara o evento falha se o nome do cliente for inválido para importação', function ($cliente) {
    $print = "server.dominio.gov.br╡01/06/2020╡07:35:35╡documento de teste.pdf╡jesxxx╡2021╡╡╡{$cliente}╡IMP-123╡2567217╡1╡1";

    Event::fake();

    PrintImporter::make()->run($print);

    Event::assertDispatched(FailureEvent::class);
    expect(Impressao::get())->toBeEmpty();
})->with([
    Str::random(256), // campo aceita no máximo 255 caracteres
    null,             // campo obrigatório
]);

test('dispara o evento falha se o nome da impressora for inválido para importação', function ($impressora) {
    $print = "server.dominio.gov.br╡01/06/2020╡07:35:35╡documento de teste.pdf╡jesxxx╡2021╡╡╡CPU-10000╡{$impressora}╡2567217╡1╡1";

    Event::fake();

    PrintImporter::make()->run($print);

    Event::assertDispatched(FailureEvent::class);
    expect(Impressao::get())->toBeEmpty();
})->with([
    Str::random(256), // campo aceita no máximo 255 caracteres
    null,             // campo obrigatório
]);

test('dispara o evento falha se a data da impressão for inválida para importação', function ($data) {
    $print = "server.dominio.gov.br╡{$data}╡07:35:35╡documento de teste.pdf╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡2567217╡1╡1";

    Event::fake();

    PrintImporter::make()->run($print);

    Event::assertDispatched(FailureEvent::class);
    expect(Impressao::get())->toBeEmpty();
})->with([
    '31/02/2020', // data inválida
    '28-02-2020', // deve ser no formato dd/mm/yyyy
    null,         // campo obrigatório
]);

test('dispara o evento falha se a hora da impressão for inválida para importação', function ($hora) {
    $print = "server.dominio.gov.br╡01/06/2020╡{$hora}╡documento de teste.pdf╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡2567217╡1╡1";

    Event::fake();

    PrintImporter::make()->run($print);

    Event::assertDispatched(FailureEvent::class);
    expect(Impressao::get())->toBeEmpty();
})->with([
    '23:61:59', // hora inválida
    '2:59:59',  // deve ser no formato hh:mm:ss
    null,       // campo obrigatório
]);

test('dispara o evento falha se o nome do arquivo impresso for inválido para importação', function () {
    //campo aceita no máximo 260 caracteres
    $arquivo = Str::random(261);

    $print = "server.dominio.gov.br╡01/06/2020╡07:35:35╡{$arquivo}╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡2567217╡1╡1";

    Event::fake();

    PrintImporter::make()->run($print);

    Event::assertDispatched(FailureEvent::class);
    expect(Impressao::get())->toBeEmpty();
});

test('o nome do arquivo é opcional', function () {
    $arquivo = null;

    $print = "server.dominio.gov.br╡01/06/2020╡07:35:35╡{$arquivo}╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡2567217╡1╡1";

    PrintImporter::make()->run($print);

    expect(Impressao::get())->toHaveCount(1);
});

test('dispara o evento falha se número de páginas for inválido para importação', function ($paginas) {
    $print = "server.dominio.gov.br╡01/06/2020╡07:35:35╡arquivo.pdf╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡2567217╡{$paginas}╡1";

    Event::fake();

    PrintImporter::make()->run($print);

    Event::assertDispatched(FailureEvent::class);
    expect(Impressao::get())->toBeEmpty();
})->with([
    'texto', // valor não conversível em inteiro
    null,    // campo obrigatório
]);

test('dispara o evento falha se número de cópias for inválido para importação', function ($copias) {
    $print = "server.dominio.gov.br╡01/06/2020╡07:35:35╡arquivo.pdf╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡2567217╡5╡{$copias}";

    Event::fake();

    PrintImporter::make()->run($print);

    Event::assertDispatched(FailureEvent::class);
    expect(Impressao::get())->toBeEmpty();
})->with([
    'texto', // valor não conversível em inteiro
    null,    // campo obrigatório
]);

test('dispara o evento falha se o tamanho do arquivo for inválido para importação', function ($tamanho) {
    $print = "server.dominio.gov.br╡01/06/2020╡07:35:35╡arquivo.pdf╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡{$tamanho}╡5╡2";

    Event::fake();

    PrintImporter::make()->run($print);

    Event::assertDispatched(FailureEvent::class);
    expect(Impressao::get())->toBeEmpty();
})->with([
    'texto', // valor não conversível em inteiro
]);

test('o tamanho do arquivo é opcional', function () {
    $tamanho = null;

    $print = "server.dominio.gov.br╡01/06/2020╡07:35:35╡documento.pdf╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡{$tamanho}╡1╡1";

    PrintImporter::make()->run($print);

    expect(Impressao::get())->toHaveCount(1);
});

test('transação faz roolback em caso de exception na persistência da impressão', function () {
    // Note que duas impressões com a mesma data, hora, usuário e impressora são considerais iguais.
    // Nesse caso, os dados da segunda impressão não devem existir no banco de dados devido ao roolback.
    $print_1 = 'server1.dominio.gov.br╡01/06/2020╡07:35:35╡documento1.pdf╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡2567217╡1╡1';
    $print_2 = 'server2.dominio.gov.br╡01/06/2020╡07:35:35╡documento2.pdf╡jesxxx╡2022╡╡╡CPU-20000╡IMP-123╡5567217╡2╡3';

    PrintImporter::make()->run($print_1);
    PrintImporter::make()->run($print_2);

    expect(Impressao::count())->toBe(1)
    ->and(Servidor::count())->toBe(1)
    ->and(Usuario::count())->toBe(1)
    ->and(Cliente::count())->toBe(1)
    ->and(Impressora::count())->toBe(1)
    ->and(Servidor::where('nome', '=', 'server2.dominio.gov.br')->first())->toBeNull();
});

test('dispara o evento exceção se houver exception na persistência da impressão', function () {
    // as impressões a seguir são consideradas iguais
    $print_1 = 'server1.dominio.gov.br╡01/06/2020╡07:35:35╡documento1.pdf╡jesxxx╡2021╡╡╡CPU-10000╡IMP-123╡2567217╡1╡1';
    $print_2 = 'server2.dominio.gov.br╡01/06/2020╡07:35:35╡documento2.pdf╡jesxxx╡2022╡╡╡CPU-20000╡IMP-123╡5567217╡2╡3';

    PrintImporter::make()->run($print_1);

    Event::fake();

    PrintImporter::make()->run($print_2);

    Event::assertDispatched(ExceptionEvent::class);
    expect(Impressao::get())->toHaveCount(1);
});

test('importa uma impressão (linha do arquivo txt) corretamente', function () {
    $servidor = 'server.dominio.gov.br';
    $cliente = 'CPU-10000';
    $impressora = 'IMP-123';

    Lotacao::factory()->create();

    $lotacao = Lotacao::first();

    Usuario::factory()
            ->for($lotacao, 'lotacao')
            ->create(['sigla' => 'jesxxx']);

    $usuario = Usuario::with('lotacao')->first();

    $print = "{$servidor}╡01/06/2020╡07:35:35╡documento de teste.pdf╡{$usuario->sigla}╡2021╡{$lotacao->id}╡╡{$cliente}╡{$impressora}╡2567217╡4╡7";

    PrintImporter::make()->run($print);

    $record = Impressao::first();

    expect(Servidor::firstWhere('nome', '=', $servidor))->toBeInstanceOf(Servidor::class)
    ->and(Cliente::firstWhere('nome', '=', $cliente))->toBeInstanceOf(Cliente::class)
    ->and(Impressora::firstWhere('nome', '=', $impressora))->toBeInstanceOf(Impressora::class)
    ->and($record)->toBeInstanceOf(Impressao::class)
    ->and($record->id)->not->toBeNull()
    ->and($record->data)->toBe('2020-06-01')
    ->and($record->hora)->toBe('07:35:35')
    ->and($record->nome_arquivo)->toBe('documento de teste.pdf')
    ->and($record->tamanho_arquivo)->toBe(2567217)
    ->and($record->qtd_pagina)->toBe(4)
    ->and($record->qtd_copia)->toBe(7)
    // Como o usuário possui lotação, ele e a sua lotação devem estar associados à impressão
    ->and($record->lotacao_id)->toBe($usuario->lotacao->id)
    ->and($record->usuario_id)->toBe($usuario->id);
});
