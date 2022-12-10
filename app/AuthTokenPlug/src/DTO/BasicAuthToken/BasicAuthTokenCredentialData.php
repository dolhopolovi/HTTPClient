<?php

namespace Merce\RestClient\AuthTokenPlug\src\DTO\BasicAuthToken;

use Merce\RestClient\HttpPlug\src\Exception\Impl\InvalidArgumentException;

class BasicAuthTokenCredentialData
{
    public function __construct(
        public readonly string $username,
        public readonly string $password
    ) {
        if (empty($this->username) || empty($this->password)) {
            throw new InvalidArgumentException('Error: empty credentials');
        }
    }

    public function __toString(): string
    {
        return base64_encode($this->username . ':' . $this->password);
    }
}