<?php

namespace App\Events;

use function App\Helpers\getLogLevels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Throwable;

/**
 * @see https://laravel.com/docs/8.x/events
 */
class ExceptionEvent
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Data e hora que o evento foi disparado.
     *
     * @var \Illuminate\Support\Carbon
     */
    public $datetime;

    /**
     * Mensagem do explicativo sobre o evento.
     *
     * @var string
     */
    public $message;

    /**
     * Dados da exception.
     *
     * - mensagem;
     * - classe;
     * - linha;
     * - código.
     *
     * @var array
     */
    public $exception_data = [];

    /**
     * Nível default do log que será criado nos termos da PSR-3.
     *
     * @var string
     *
     * @see https://www.php-fig.org/psr/psr-3/
     */
    public $level = 'critical';

    /**
     * Dados de contexto do momento em que o evento foi disparado.
     *
     * @var mixed|null
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param string      $message   Mensagem contextual sobre o evento
     * @param Throwable   $exception Exception que acionou o evento
     * @param string|null $level     Nível do log nos termos da PSR-3
     * @param array|null  $data      Dados de contexto do momento em que o
     *                               evento foi disparado
     *
     * @return void
     *
     * @see https://www.php-fig.org/psr/psr-3/ Informações sobre a PS-3
     */
    public function __construct(string $message, Throwable $exception, ?string $level, ?array $data)
    {
        $this->datetime = now();
        $this->message = $message;

        $this->exception_data['message'] = $exception->getMessage();
        $this->exception_data['class'] = get_class($exception);
        $this->exception_data['line'] = $exception->getFile().'@'.$exception->getLine();
        $this->exception_data['code'] = $exception->getCode();

        if ($level && getLogLevels()->has($level)) {
            $this->level = $level;
        }

        $this->data = $data;
    }
}
