<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\MiddlewareContainer\Impl;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Merce\RestClient\HttpPlug\src\Middleware\IMiddleware;
use Merce\RestClient\HttpPlug\src\MiddlewareContainer\IMiddlewareHandler;

class StackMiddlewareHandler implements IMiddlewareHandler
{

    /* @var IMiddleware[] $stack */
    private array $middlewareList;

    public function __construct(IMiddleware ...$middlewareList)
    {

        $this->middlewareList = $middlewareList;
    }

    /**
     * @param  IMiddleware  $middleware
     * @return void
     */
    public function push(IMiddleware $middleware): void
    {

        $this->middlewareList[] = $middleware;
    }

    /**
     * @return IMiddleware|null
     */
    public function pop(): ?IMiddleware
    {

        return array_shift($this->middlewareList);
    }

    /**
     * @param  callable  $requestChainLast
     * @param  callable  $responseChainLast
     * @return callable
     */
    public function resolve(callable $requestChainLast, callable $responseChainLast): callable
    {

        $responseChainNext = $responseChainLast;
        foreach ($this->middlewareList as $m) {
            $responseChainNext = fn(RequestInterface $request, ResponseInterface $response) => $m->handleResponse($request, $response, $responseChainNext);
        }

        $requestChainLast = fn(RequestInterface $request) => $requestChainLast($request, $responseChainNext);

        $middlewareList = array_reverse($this->middlewareList);

        $requestChainNext = $requestChainLast;
        foreach ($middlewareList as $m) {
            $requestChainNext = fn(RequestInterface $request) => $m->handleRequest($request, $requestChainNext);
        }

        return $requestChainNext;
    }
}