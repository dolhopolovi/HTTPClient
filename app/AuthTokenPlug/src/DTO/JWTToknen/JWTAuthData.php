<?php

declare(strict_types = 1);

namespace Merce\RestClient\AuthTokenPlug\src\DTO\JWTToknen;

use Psr\Http\Message\RequestInterface;

class JWTAuthData
{

    public function __construct(
        public RequestInterface $request,
        public readonly string $username,
        public readonly string $password
    ) {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {

        return base64_encode("{$this->request->getUri()->__toString()}$this->username$this->password");
    }
}