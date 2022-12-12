<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\HttpPlug\Middleware;

use PHPUnit\Framework\TestCase;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;
use Merce\RestClient\HttpPlug\src\Exception\Impl\InvalidArgumentException;
use Merce\RestClient\HttpPlug\src\Core\Builder\Request\Impl\RequestBuilder;
use Merce\RestClient\AuthTokenPlug\src\DTO\BasicAuthToken\BasicAuthTokenCredentialData;
use Merce\RestClient\AuthTokenPlug\src\Core\TokenController\BasicAuthToken\ManualBasicAuthTokenController;

/**
 * Test BasicAuthMiddleware class
 */
class BasicAuthTest extends TestCase
{

    /**
     * "Expect" request header equal to encoded [username:password]
     *
     * @return void
     */
    public function testBasicAuthHeader(): void
    {

        $authController = new ManualBasicAuthTokenController(new BasicAuthTokenCredentialData('username', 'password'));
        $request = $authController->authenticate((new RequestBuilder())->setUri('/test.login')->setMethod(EHttpMethod::GET)->getRequest());
        $this->assertEquals('Basic ' . base64_encode('username:password'), $request->getHeaderLine('Authorization'));
    }

    /**
     * Test throwing InvalidArgumentException when invalid credentials have been provided
     *
     * @return void
     */
    public function testInvalidCredentials(): void
    {

        $this->expectException(InvalidArgumentException::class);

        $middleware = new ManualBasicAuthTokenController(new BasicAuthTokenCredentialData('', ''));
    }
}
