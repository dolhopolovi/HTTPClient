<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Middleware\Impl;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Merce\RestClient\HttpPlug\src\Middleware\IMiddleware;
use Merce\RestClient\HttpPlug\src\Exception\Impl\InvalidArgumentException;

class BasicAuthMiddleware implements IMiddleware
{

    /**
     * @param  string  $username
     * @param  string  $password
     * @throws InvalidArgumentException
     */
    public function __construct(
        private readonly string $username,
        private readonly string $password
    ) {

        if (empty($this->username) || empty($this->password)) {
            throw new InvalidArgumentException('Error: empty credentials');
        }
    }

    /**
     * @param  RequestInterface  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handleRequest(RequestInterface $request, callable $next): mixed
    {

        $request = $request->withAddedHeader('Authorization', sprintf('Basic %s', base64_encode($this->username . ':' . $this->password)));

        return $next($request);
    }

    /**
     * @param  RequestInterface  $request
     * @param  ResponseInterface  $response
     * @param  callable  $next
     * @return mixed
     */
    public function handleResponse(RequestInterface $request, ResponseInterface $response, callable $next): mixed
    {

        return $next($request, $response);
    }
}