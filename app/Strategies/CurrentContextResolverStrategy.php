<?php

namespace App\Strategies;

use PHPNomad\Auth\Enums\SessionContexts;
use PHPNomad\Auth\Exceptions\AuthException;
use PHPNomad\Auth\Interfaces\CurrentContextResolverStrategy as CurrentContextResolverStrategyInterface;
use PHPNomad\Utils\Helpers\Arr;

class CurrentContextResolverStrategy implements CurrentContextResolverStrategyInterface
{

    /**
     * Returns true if the current request is a REST request.
     *
     * @return bool
     */
    protected function isRest(): bool
    {
        $expectsJson = str_contains(Arr::get($_SERVER, 'HTTP_ACCEPT', ''), 'application/json');
        $isClockwork = str_contains(Arr::get($_SERVER, 'REQUEST_URI', ''), '__clockwork');

        return $expectsJson || $isClockwork;
    }

    protected function isWeb(): bool
    {
        return !$this->isRest() && $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function getCurrentContext(): string
    {
        if ($this->isRest()) {
            return SessionContexts::Rest;
        }

        if ($this->isWeb()) {
            return SessionContexts::Web;
        }

        throw new AuthException('Could not detect context from request. This usually happens when you are using a REST request but did not set the HTTP_ACCEPT header to application/json');
    }
}