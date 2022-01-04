<?php

namespace App\Listeners;

use App\Events\ExceptionEvent;
use App\Events\FailureEvent;
use App\Events\RegularEvent;
use Illuminate\Support\Facades\Log;

/**
 * @see https://laravel.com/docs/8.x/events#event-subscribers
 */
class LogEventSubscriber
{
    /**
     * Handle the event.
     *
     * @param \App\Events\RegularEvent $event
     */
    public function handleRegularEvent($event): void
    {
        Log::{$event->level}($event->message, [
            'date' => $event->datetime,
            'context' => $event->data,
        ]);
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\FailureEvent $event
     */
    public function handleFailureEvent($event): void
    {
        Log::{$event->level}($event->message, [
            'date' => $event->datetime,
            'context' => $event->data,
        ]);
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\ExceptionEvent $event
     */
    public function handleExceptionEvent($event): void
    {
        Log::{$event->level}($event->message, [
            'date' => $event->datetime,
            'context' => $event->data,
            'data' => $event->exception_data,
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events): array
    {
        return [
            RegularEvent::class => 'handleRegularEvent',
            FailureEvent::class => 'handleFailureEvent',
            ExceptionEvent::class => 'handleExceptionEvent',
        ];
    }
}
