<?php

declare(strict_types = 1);

namespace Merce\RestClient\TokenParser\src\DTO;

class TokenPayloadUser
{

    public function __construct(
        public readonly string $firstName = '',
        public readonly string $lastName = ''
    ) {
    }
}