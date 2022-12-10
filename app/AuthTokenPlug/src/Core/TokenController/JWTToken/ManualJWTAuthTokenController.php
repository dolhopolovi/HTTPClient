<?php

namespace Merce\RestClient\AuthTokenPlug\src\Core\TokenController\JWTToken;

use Http\Message\Authentication;
use Psr\Http\Message\RequestInterface;
use Merce\RestClient\HttpPlug\src\Exception\Impl\InvalidArgumentException;

class ManualJWTAuthTokenController implements Authentication
{

    public function __construct(private readonly string $token) {
        if (empty($token)) {
            throw new InvalidArgumentException('Error: accessToken token is empty');
        }
    }

    public function authenticate(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('Authorization', sprintf('Bearer %s', $this->token));
    }
}