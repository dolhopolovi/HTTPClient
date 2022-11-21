<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\MiddlewareContainer;

use Merce\RestClient\HttpPlug\src\Middleware\IMiddleware;

interface IMiddlewareHandler
{

    /**
     * @param  IMiddleware  $middleware
     * @return void
     */
    public function push(IMiddleware $middleware): void;

    /**
     * @return IMiddleware|null
     */
    public function pop(): ?IMiddleware;

    /**
     * @param  callable  $requestChainLast
     * @param  callable  $responseChainLast
     * @return callable
     */
    public function resolve(callable $requestChainLast, callable $responseChainLast): callable;
}