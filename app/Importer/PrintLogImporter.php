<?php

namespace App\Importer;

use App\Events\ExceptionEvent;
use App\Events\FailureEvent;
use App\Events\RegularEvent;
use App\Importer\Contract\IImportablePrintLog;
use Bcremer\LineReader\LineReader;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

/**
 * Importador dos arquivos de log de impressão.
 */
final class PrintLogImporter implements IImportablePrintLog
{
    /**
     * File System em que estão armazenados os logs de impressão.
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    private $file_system;

    /**
     * Create new class instance.
     */
    public function __construct()
    {
        $this->file_system = Storage::disk('log-impressao');
    }

    /**
     * Create new class instance.
     */
    public static function make(): static
    {
        return new static();
    }

    /**
     * {@inheritdoc}
     */
    public function run(): void
    {
        $this->start();
        $this->process();
        $this->finish();
    }

    /**
     * Tratativas iniciais para a importação.
     */
    private function start(): void
    {
        RegularEvent::dispatch(
            __('job.importacao.iniciada', ['attribute' => __('strings.log_impressao')]),
            'notice',
            null
        );
    }

    /**
     * Execução propriamente dita da importação.
     */
    private function process(): void
    {
        foreach ($this->printLogFiles() as $print_log_file) {
            $saved = $this->save($print_log_file);

            if ($saved) {
                $this->delete($print_log_file);
            }

            RegularEvent::dispatch(
                __('job.importacao.processado', ['attribute' => $print_log_file]),
                'info',
                null
            );
        }
    }

    /**
     * Lista de arquivos de log de impressão para serem importados.
     *
     * Não retonra o full path, mas tão somente o file name, filtrando os
     * arquivos para não retornar os logs de erro de impressão.
     *
     * @return array Ex.: `['21-02-2020.txt', '22-02-2020.txt', ... ]`
     */
    private function printLogFiles(): array
    {
        return Arr::where(
            $this->file_system->files(),
            function (string $print_log_file) {
                return ! Str::of($print_log_file)->contains('erro');
            }
        );
    }

    /**
     * Persistência para todas as impressões presentes no arquivo de log.
     *
     * @param string $print_log_file Ex.: 21-02-2012.txt
     *
     * @return bool true se a persistência integral do arquivo foi feita ou
     *              false caso alguma linha do arquivo tenha falhado
     */
    private function save(string $print_log_file): bool
    {
        /*
         * Utiliza-se a biblioteca LineReader para fazer a leitura dos arquivos
         * de log, pois eles podem ser grandes o que poderia levar ao estouro
         * de memória.
         * Assim, em vez de se ler o arquivo inteiro de uma vez, a biblioteca
         * faz a leitura do arquivo linha por linha.
         * Se necessário, para ver o consumo de mermória, basta colocar o
         * trecho abaixo onde se deseja medi-lo.
         *
         * php echo memory_get_peak_usage(false)/1024/1024 . PHP_EOL;
         *
         * Para maiores informações:
         * https://www.php.net/manual/pt_BR/ini.core.php#ini.memory-limit
         * https://www.php.net/manual/pt_BR/function.memory-get-usage.php
         * https://stackoverflow.com/questions/15745385/memory-get-peak-usage-with-real-usage
         * https://www.sitepoint.com/performant-reading-big-files-php/
         * https://github.com/bcremer/LineReader
         */
        try {
            foreach (LineReader::readLines($this->fullPath($print_log_file)) as $print) {
                PrintImporter::make()->run((string) $print);
            }

            return true;
        } catch (Throwable $exception) {
            ExceptionEvent::dispatch(
                __('error.arquivo.importacao', ['attribute' => $print_log_file]),
                $exception,
                'critical',
                [
                    'file' => $print_log_file,
                    'disk' => $this->file_system,
                ]
            );

            return false;
        }
    }

    /**
     * Caminho completo do arquivo informado.
     *
     * @param string $print_log_file ex.: 21-02-2012.txt
     *
     * @return string Full path
     */
    private function fullPath(string $print_log_file): string
    {
        return $this->file_system->path($print_log_file);
    }

    /**
     * Exclui o arquivo log de impressão informado.
     *
     * @param string $print_log_file ex.: 21-02-2012.txt
     */
    private function delete(string $print_log_file): void
    {
        if (App::environment('production')) {
            $deleted = $this->file_system->delete($print_log_file);

            FailureEvent::dispatchIf(
                ! $deleted,
                __('error.arquivo.delete', ['attribute' => $print_log_file]),
                'critical',
                [
                    'file' => $print_log_file,
                    'disk' => $this->file_system,
                ]
            );
        } else {
            RegularEvent::dispatch(
                __('strings.del_not_producao', ['attribute' => $print_log_file]),
                'info',
                null
            );
        }
    }

    /**
     * Conclusão do processamento de importação.
     */
    private function finish(): void
    {
        RegularEvent::dispatch(
            __('job.importacao.concluido', ['attribute' => __('strings.log_impressao')]),
            'notice',
            null
        );
    }
}
