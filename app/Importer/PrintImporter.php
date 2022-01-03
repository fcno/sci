<?php

namespace App\Importer;

use App\Events\ExceptionEvent;
use App\Events\FailureEvent;
use App\Importer\Contract\IImportablePrint;
use App\Models\Cliente;
use App\Models\Impressao;
use App\Models\Impressora;
use App\Models\Lotacao;
use App\Models\Servidor;
use App\Models\Usuario;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

use function App\Helpers\stringToArrayAssoc;

/**
 * Importador para uma impressão, isto é, uma linha do arquivo de log.
 */
final class PrintImporter implements IImportablePrint
{
    /**
     * Linha do arquivo de log de impressão que representa uma impressão que
     * será imporatada.
     *
     * @var string $print_line
     */
    private $print_line;

    /**
     * Delimitador de separação dos campos da impressão.
     *
     * @var string $delimiter
     */
    private $delimiter = '╡';

    /**
     * Campos, na sequenciados corretamente, que compõem uma impressão.
     *
     * @var array $fields
     */
    private $fields = [
        'servidor',
        'data',
        'hora',
        'nome_arquivo',
        'sigla',
        'cargo_id',
        'setor_id',
        'funcao_id',
        'cliente',
        'impressora',
        'tamanho_arquivo',
        'qtd_pagina',
        'qtd_copia'
    ];

    /**
     * Regras que serão aplicadas aos campos que serão importados.
     *
     * @var array $rules
     */
    protected $rules = [
        'servidor'        => ['required', 'string',  'max:255'],
        'data'            => ['required', 'string',  'date_format:d/m/Y'],
        'hora'            => ['required', 'string',  'date_format:H:i:s'],
        'nome_arquivo'    => ['nullable', 'max:260'],
        'sigla'           => ['required', 'string',  'max:20'],
        'setor_id'        => ['nullable', 'integer', 'exists:lotacoes,id'],
        'cliente'         => ['required', 'string',  'max:255'],
        'impressora'      => ['required', 'string',  'max:255'],
        'tamanho_arquivo' => ['nullable', 'integer', 'gte:1'],
        'qtd_pagina'      => ['required', 'integer', 'gte:1'],
        'qtd_copia'       => ['required', 'integer', 'gte:1']
    ];

    /**
     * Create new class instance.
     *
     * @return static
     */
    public static function make(): static
    {
        return new static();
    }

    /**
     * @inheritdoc
     */
    public function run(string $print): void
    {
        $this->print_line = $print;

        $input = stringToArrayAssoc(
            $this->fields,
            $this->print_line,
            $this->delimiter
        );

        $validated = $this->validateAndLogError($input);

        if ($validated) {
            $this->save($validated);
        }
    }

    /**
     * Retorna os inputs válidos para inserção de acordo com as rules de importação.
     *
     * Em caso de falha de validação, retorna null e loga as falhas.
     *
     * @param array  $inputs  Ex.: `['key' => 'value', ... ]`
     *
     * @return array|null     Ex.: `['key' => 'value', ... ]`
     */
    protected function validateAndLogError(array $inputs): ?array
    {
        $validator = Validator::make($inputs, $this->rules);

        if ($validator->fails()) {
            $this->triggerFailure(
                __('error.validacao'),
                $inputs,
                $validator->getMessageBag()->toArray()
            );
            return null;
        }

        return $validator->validated();
    }

    /**
     * Dispara um evento do tipo **failure** para registro dos dados.
     *
     * @param string  $msg            sobre a falha
     * @param array   $input          dados que seriam persistidos
     * @param array   $validator_bag  falhas de validação
     *
     * @return void
     */
    private function triggerFailure(string $msg, array $input, array $validator_bag): void
    {
        FailureEvent::dispatch(
            $msg,
            'warning',
            [
                'input'       => $input,
                'rules'       => $this->rules,
                'print_line'  => $this->print_line,
                'delimiter'   => $this->delimiter,
                'fields'      => $this->fields,
                'error_bag'   => $validator_bag
            ]
        );
    }

    /**
     * Dispara um evento do tipo **exception** para registro dos dados.
     *
     * @param string     $msg        sobre a falha
     * @param Throwable  $exception  Exception que foi gerada
     * @param array      $input      dados que originaram a falha
     *
     * @return void
     */
    private function triggerException(string $msg, Throwable $exception, array $input): void
    {
        ExceptionEvent::dispatch(
            $msg,
            $exception,
            'critical',
            [
                'input'     => $input,
                'rules'     => $this->rules,
                'print'     => $this->print_line,
                'delimiter' => $this->delimiter,
                'fields'    => $this->fields
            ]
        );
    }

    /**
     * Faz a persistência da impressão.
     *
     * @param array $validated
     *
     * @return void
     */
    protected function save(array $validated): void
    {
        DB::beginTransaction();

        try {
            $servidor   = Servidor::firstOrCreate(['nome' => $validated['servidor']]);
            $impressora = Impressora::firstOrCreate(['nome' => $validated['impressora']]);
            $cliente    = Cliente::firstOrCreate(['nome' => $validated['cliente']]);
            $usuario    = Usuario::firstOrCreate(['sigla' => $validated['sigla']]);
            $lotacao    = Lotacao::find($validated['setor_id']);

            $impressao = new Impressao;

            $impressao->data            = Carbon::createFromFormat('d/m/Y', $validated['data']);
            $impressao->hora            = Carbon::createFromFormat('H:i:s', $validated['hora']);
            $impressao->nome_arquivo    = Arr::get($validated, 'nome_arquivo') ?: null;
            $impressao->tamanho_arquivo = Arr::get($validated, 'tamanho_arquivo') ?: null;
            $impressao->qtd_pagina      = $validated['qtd_pagina'];
            $impressao->qtd_copia       = $validated['qtd_copia'];

            $impressao->usuario()->associate($usuario);
            $impressao->cliente()->associate($cliente);
            $impressao->impressora()->associate($impressora);
            $impressao->servidor()->associate($servidor);

            if ($lotacao) {
                $impressao->lotacao()->associate($lotacao);
            }

            $impressao->save();

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            $this->triggerException(
                __('error.duplicado'),
                $exception,
                $validated
            );
        }
    }
}
