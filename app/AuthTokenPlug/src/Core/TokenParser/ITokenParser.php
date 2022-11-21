<?php

declare(strict_types = 1);

namespace Merce\RestClient\AuthTokenPlug\src\Core\TokenParser;

use Merce\RestClient\AuthTokenPlug\src\DTO\TokenPayLoad;
use Merce\RestClient\AuthTokenPlug\src\DTO\TokenPayloadUser;

interface ITokenParser
{

    /**
     * @param  string  $token
     * @return TokenPayLoad
     */
    public function parseTokenPayload(string $token): TokenPayLoad;

    /**
     * @param  object  $d_token
     * @return TokenPayloadUser
     */
    public function getPayLoadUser(object $d_token): TokenPayloadUser;

    /**
     * @param  object  $d_token
     * @return int|null
     */
    public function getPayLoadExp(object $d_token): ?int;
}