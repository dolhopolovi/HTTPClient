<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Core\Middleware\Impl;

use Http\Message\Authentication;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Merce\RestClient\HttpPlug\src\Core\Middleware\IMiddleware;

class AuthMiddleware implements IMiddleware
{

    public function __construct(
        private readonly Authentication $authentication
    ) {
    }

    /**
     * @param  RequestInterface  $request
     * @return RequestInterface
     * @throws InvalidArgumentException
     */
    public function handleForRequest(RequestInterface $request): RequestInterface
    {

        return $this->authentication->authenticate($request);
    }

    /**
     * @param  RequestInterface  $request
     * @param  ResponseInterface  $response
     * @return ResponseInterface
     */
    public function handleForResponse(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        return $response;
    }
}
