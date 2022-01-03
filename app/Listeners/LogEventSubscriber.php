<?php

namespace App\Listeners;

use App\Events\{ExceptionEvent, FailureEvent, RegularEvent};
use Illuminate\Support\Facades\Log;

/**
 * @link https://laravel.com/docs/8.x/events#event-subscribers
 */
class LogEventSubscriber
{
    /**
     * Handle the event.
     *
     * @param \App\Events\RegularEvent  $event
     *
     * @return void
     */
    public function handleRegularEvent($event): void
    {
        Log::{$event->level}($event->message, [
            'date'    => $event->datetime,
            'context' => $event->data
        ]);
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\FailureEvent  $event
     *
     * @return void
     */
    public function handleFailureEvent($event): void
    {
        Log::{$event->level}($event->message, [
            'date'    => $event->datetime,
            'context' => $event->data
        ]);
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\ExceptionEvent  $event
     *
     * @return void
     */
    public function handleExceptionEvent($event): void
    {
        Log::{$event->level}($event->message, [
            'date'    => $event->datetime,
            'context' => $event->data,
            'data'    => $event->exception_data
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher  $events
     *
     * @return array
     */
    public function subscribe($events): array
    {
        return [
            RegularEvent::class   => 'handleRegularEvent',
            FailureEvent::class   => 'handleFailureEvent',
            ExceptionEvent::class => 'handleExceptionEvent',
        ];
    }
}
