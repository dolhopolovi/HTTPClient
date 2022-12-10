<?php

declare(strict_types = 1);

namespace Merce\RestClient\AuthTokenPlug\src\DTO\JWTToknen;

class TokenPayloadUser
{

    public function __construct(
        public readonly string $firstName = '',
        public readonly string $lastName = ''
    ) {
    }
}