<?php

declare(strict_types = 1);

namespace Merce\RestClient\AuthTokenPlug\src\DTO\JWTToknen;

class JWTAuthData
{

    public function __construct(
        public string $sourceRoute,
        public readonly string $username,
        public readonly string $password
    ) {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {

        return base64_encode("{$this->sourceRoute}{$this->username}{$this->password}");
    }
}