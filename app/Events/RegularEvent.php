<?php

namespace App\Events;

use App\Extras\Log\TraitLog;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use function App\Helpers\getLogLevels;

/**
 * @author Fábio Cassiano <fabiocassiano@jfes.jus.br>
 *
 * @link https://laravel.com/docs/8.x/events
 */
class RegularEvent
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
     * Nível default do log que será criado nos termos da PSR-3.
     *
     * @var string
     *
     * @link https://www.php-fig.org/psr/psr-3/
     */
    public $level = 'info';

    /**
     * Dados de contexto do momento em que o evento foi disparado.
     *
     * @var mixed|null
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param string       $message Mensagem contextual sobre o evento
     * @param string|null  $level   Nível do log nos termos da PSR-3
     * @param array|null   $data    Dados de contexto do momento em que o
     * evento foi disparado
     *
     * @return void
     *
     * @link https://www.php-fig.org/psr/psr-3/ Informações sobre a PS-3
     */
    public function __construct(string $message, ?string $level, ?array $data)
    {
        $this->datetime = now();
        $this->message = $message;

        if ($level && getLogLevels()->has($level)) {
            $this->level = $level;
        }

        $this->data = $data;
    }
}
