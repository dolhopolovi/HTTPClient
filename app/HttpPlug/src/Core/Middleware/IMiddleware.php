<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Core\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface IMiddleware
{

    /**
     * @param  RequestInterface  $request
     * @return RequestInterface
     */
    public function handleForRequest(RequestInterface $request): RequestInterface;

    /**
     * @param  RequestInterface  $request
     * @param  ResponseInterface  $response
     * @return ResponseInterface
     */
    public function handleForResponse(RequestInterface $request, ResponseInterface $response): ResponseInterface;
}
