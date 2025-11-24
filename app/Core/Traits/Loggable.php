<?php

namespace App\Core\Traits;

use Illuminate\Support\Facades\Log;

trait Loggable
{
    /**
     * Log an info message
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    protected function logInfo(string $message, array $context = []): void
    {
        Log::info($this->getLogPrefix() . $message, $context);
    }

    /**
     * Log an error message
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    protected function logError(string $message, array $context = []): void
    {
        Log::error($this->getLogPrefix() . $message, $context);
    }

    /**
     * Get the log prefix
     *
     * @return string
     */
    protected function getLogPrefix(): string
    {
        return '[' . class_basename($this) . '] ';
    }
}
