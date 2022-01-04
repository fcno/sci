<?php

/**
 * @link https://pestphp.com/docs/
 */

use App\Events\{ExceptionEvent, FailureEvent, RegularEvent};
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

test('o log no nível default está sendo registrado corretamente pelo handler de exceção do LogEventSubscriber', function() {
    $msg       = 'context message';
    $exception = new Exception();

    Log::shouldReceive('critical')
        ->once()
        ->withArgs(function ($message) use ($msg) {
            return Str::of($message)->contains($msg);
    });

    ExceptionEvent::dispatch(
        $msg,
        $exception,
        null,
        null
    );
});

test('é possível redefinir o tipo de log a ser registrado pelo handler de exceção do LogEventSubscriber', function() {
    //https://www.php-fig.org/psr/psr-3/
    $level     = 'emergency';
    $exception = new Exception();

    Log::shouldReceive($level)
        ->once();

    ExceptionEvent::dispatch(
        'context message',
        $exception,
        $level,
        null
    );
});

test('o log no nível default está sendo registrado corretamente pelo handler de falha do LogEventSubscriber', function() {
    $msg = 'context message';

    Log::shouldReceive('error')
        ->once()
        ->withArgs(function ($message) use ($msg) {
            return Str::of($message)->contains($msg);
    });

    FailureEvent::dispatch(
        $msg,
        null,
        null
    );
});

test('é possível redefinir o tipo de log a ser registrado pelo handler de falha do LogEventSubscriber', function() {
    //https://www.php-fig.org/psr/psr-3/
    $level = 'warning';

    Log::shouldReceive($level)
        ->once();

    FailureEvent::dispatch(
        'context message',
        $level,
        null
    );
});

test('o log no nível default está sendo registrado corretamente pelo handler regular do LogEventSubscriber', function() {
    $msg = 'context message';

    Log::shouldReceive('info')
        ->once()
        ->withArgs(function ($message) use ($msg) {
            return Str::of($message)->contains($msg);
    });

    RegularEvent::dispatch(
        $msg,
        null,
        null
    );
});

test('é possível redefinir o tipo de log a ser registrado pelo handler regular do LogEventSubscriber', function() {
    //https://www.php-fig.org/psr/psr-3/
    $level = 'debug';

    Log::shouldReceive($level)
        ->once();

    RegularEvent::dispatch(
        'context message',
        $level,
        null
    );
});
