<?php

declare(strict_types = 1);

namespace Merce\RestClient\AuthTokenPlug\src\Core\TokenParser\Impl;

use Merce\RestClient\AuthTokenPlug\src\DTO\JWTToknen\TokenPayLoad;
use Merce\RestClient\AuthTokenPlug\src\Core\TokenParser\ITokenParser;
use Merce\RestClient\AuthTokenPlug\src\DTO\JWTToknen\TokenPayloadUser;

class JWTTokenParser implements ITokenParser
{

    /**
     * @param  string  $token
     * @return TokenPayLoad
     */
    public function parseTokenPayload(string $token): TokenPayLoad
    {

        $tokenPayload = explode('.', $token)[1];

        $d_tokenPayload = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', $tokenPayload))));

        $payLoadUser = $this->getPayLoadUser($d_tokenPayload);
        $tokenExp = $this->getPayLoadExp($d_tokenPayload);

        return new TokenPayLoad(
            user: $payLoadUser, expDate: $tokenExp
        );
    }

    /**
     * @param  object  $d_token
     * @return TokenPayloadUser
     */
    public function getPayLoadUser(object $d_token): TokenPayloadUser
    {

        $user = explode(' ', $d_token->name);

        return new TokenPayloadUser(
            firstName: $user[0] ?? '', lastName: $user[1] ?? ''
        );
    }

    /**
     * @param  object  $d_token
     * @return int|null
     */
    public function getPayLoadExp(object $d_token): ?int
    {

        return $d_token->exp ?? null;
    }
}