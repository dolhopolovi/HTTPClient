<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\AuthTokenPlug\TokenParser;

use PHPUnit\Framework\TestCase;
use Merce\RestClient\AuthTokenPlug\src\DTO\JWTToknen\TokenPayLoad;
use Merce\RestClient\AuthTokenPlug\src\DTO\JWTToknen\TokenPayloadUser;
use Merce\RestClient\AuthTokenPlug\src\Core\TokenParser\Impl\JWTTokenParser;

/**
 * Test JWTTokenParser class
 */
class JWTTokenParserTest extends TestCase
{

    /**
     * "Expect" expected_tokenPayload equal to actual tokenPayload
     *
     * @return void
     */
    public function testparseTokenPayload(): void
    {

        $token = 'eyJhbGciOiJIUzM4NCIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.bQTnz6AuMJvmXXQsVPrxeQNvzDkimo7VNXxHeSBfClLufmCVZRUuyTwJF311JHuh';

        $jwtTokenParser = new JWTTokenParser();

        $tokenPayload = $jwtTokenParser->parseTokenPayload($token);

        $expected_tokenPayload = new TokenPayLoad(new TokenPayloadUser('John', 'Doe'), null);

        $this->assertEquals($expected_tokenPayload, $tokenPayload);
    }
}