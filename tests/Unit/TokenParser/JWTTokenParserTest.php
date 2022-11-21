<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\TokenParser;

use PHPUnit\Framework\TestCase;
use Merce\RestClient\TokenParser\src\DTO\TokenPayLoad;
use Merce\RestClient\TokenParser\src\Impl\JWTTokenParser;
use Merce\RestClient\TokenParser\src\DTO\TokenPayloadUser;

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

        /* @var TokenPayLoad $tokenPayload */
        $tokenPayload = $jwtTokenParser->parseTokenPayload($token);

        $expected_tokenPayload = new TokenPayLoad(new TokenPayloadUser('John', 'Doe'), null);

        $this->assertEquals($expected_tokenPayload, $tokenPayload);
    }
}