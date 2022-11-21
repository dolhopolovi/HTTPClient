<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface IMiddleware
{

    /**
     * @param  RequestInterface  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handleRequest(RequestInterface $request, callable $next): mixed;

    /**
     * @param  RequestInterface  $request
     * @param  ResponseInterface  $response
     * @param  callable  $next
     * @return mixed
     */
    public function handleResponse(RequestInterface $request, ResponseInterface $response, callable $next): mixed;
}