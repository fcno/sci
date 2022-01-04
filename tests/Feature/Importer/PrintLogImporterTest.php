<?php

/**
 * @see https://pestphp.com/docs/
 */

use App\Events\ExceptionEvent;
use App\Events\FailureEvent;
use App\Events\RegularEvent;
use App\Importer\PrintLogImporter;
use App\Models\Cliente;
use App\Models\Impressao;
use App\Models\Impressora;
use App\Models\Servidor;
use App\Models\Usuario;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->print_log_files = [
        '01-12-2020.txt' => 'server1.domain.gov.br╡01/12/2020╡08:00:00╡report.pdf╡jesaaa╡2021╡╡╡CPU-10000╡IMP-111╡1000╡4╡2'.PHP_EOL.
            'server2.domain.gov.br╡01/12/2020╡10:30:00╡private.pdf╡jesbbb╡2021╡╡╡CPU-10000╡IMP-222╡5000╡8╡2'.PHP_EOL,

        '02-12-2020.txt' => 'server1.domain.gov.br╡02/12/2020╡11:00:00╡report.pdf╡jesaaa╡2021╡╡╡CPU-10000╡IMP-333╡3000╡4╡2'.PHP_EOL.
            'server1.domain.gov.br╡02/12/2020╡13:15:15╡games.pdf╡jesccc╡2021╡╡╡CPU-20000╡IMP-222╡1000╡4╡1'.PHP_EOL.
            'server2.domain.gov.br╡02/12/2020╡18:01:50╡rules.pdf╡jesccc╡2021╡╡╡CPU-20000╡IMP-111╡2000╡9╡2'.PHP_EOL,

        '03-12-2020.txt' => '',
    ];

    $this->fake_disk = Storage::fake('log-impressao');

    foreach ($this->print_log_files as $file_name => $content) {
        $this->fake_disk->put($file_name, $content);
    }
});

afterEach(function () {
    $this->fake_disk = Storage::fake('log-impressao');
});

test('o importador retorna o objeto da classe corretamente no método make', function () {
    expect(PrintLogImporter::make())->toBeInstanceOf(PrintLogImporter::class);
});

test('importa o log de impressão corretamente', function () {
    PrintLogImporter::make()->run();

    expect(Impressao::get())->toHaveCount(5)
    ->and(Servidor::get())->toHaveCount(2)
    ->and(Usuario::get())->toHaveCount(3)
    ->and(Cliente::get())->toHaveCount(2)
    ->and(Impressora::get())->toHaveCount(3);
});

test('dispara o evento RegularEvent para registrar o início, a conclusão, a importação do log e a sua exclusão caso estivesse em produção', function () {
    Event::fake();

    PrintLogImporter::make()->run();

    //1 inicio, 1 conclusão e 3 tentativas de exclusão (uma para cada arquivo) e três processamentos de arquivo.
    Event::assertDispatched(RegularEvent::class, 8);
    Event::assertNotDispatched(FailureEvent::class);
    Event::assertNotDispatched(ExceptionEvent::class);

    //arquivos não foram excluídos após importação, pois não está em produção.
    $this->fake_disk->assertExists(array_keys($this->print_log_files));

    expect(Impressao::get())->toHaveCount(5);
});

test('exclui todos os arquivos importados se estiver em produção', function () {
    $this->fake_disk->assertExists(array_keys($this->print_log_files));

    App::shouldReceive('environment')
        ->times(3) //Será acionado uma vez para a exclusão de cada arquivo
        ->andReturn('production');

    PrintLogImporter::make()->run();

    $this->fake_disk->assertMissing(array_keys($this->print_log_files));

    expect(Impressao::get())->toHaveCount(5);
});
