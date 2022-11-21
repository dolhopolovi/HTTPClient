<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Middleware\Impl;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Merce\RestClient\AuthTokenPlug\src\Core\TokenManager\JWTTokenManager;
use Merce\RestClient\HttpPlug\src\Exception\Impl\InvalidArgumentException;

class JWTAuthMiddleware
{

    private function __construct(
        private readonly string $token = '',
        private readonly ?JWTTokenManager $jwtTokenManager = null
    ) {
    }

    public static function createBYToken(string $token): self
    {

        if (empty($token)) {
            throw new InvalidArgumentException('Error: accessToken token is empty');
        }
        return new self(token: $token);
    }

    public static function createByJWTTokenManager(JWTTokenManager $jwtTokenManager): self
    {

        return new self(jwtTokenManager: $jwtTokenManager);
    }

    /**
     * @param  RequestInterface  $request
     * @param  callable  $next
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function handleRequest(RequestInterface $request, callable $next): mixed
    {

        $request = $request->withAddedHeader('Authorization', sprintf('Bearer %s', $this->token ? : $this->jwtTokenManager->get()));

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