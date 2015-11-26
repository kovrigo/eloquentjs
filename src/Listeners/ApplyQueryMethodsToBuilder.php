<?php

namespace EloquentJs\Listeners;

use EloquentJs\Events\EloquentJsWasCalled;
use EloquentJs\Translators\QueryTranslator;

class ApplyQueryMethodsToBuilder
{
    /**
     * @var QueryTranslator
     */
    protected $translator;

    /**
     * Create the event listener.
     *
     * @param QueryTranslator $translator
     */
    public function __construct(QueryTranslator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Handle the event.
     *
     * @param EloquentJsWasCalled $event
     * @return void
     */
    public function handle(EloquentJsWasCalled $event)
    {
        if ($event->stack) {
            $this->translator->source($event->stack);
        }

        $this->translator->applyTo($event->builder);
    }
}
