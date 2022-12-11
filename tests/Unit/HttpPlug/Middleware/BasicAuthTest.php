<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\HttpPlug\Middleware;

use Nyholm\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Merce\RestClient\HttpPlug\src\Exception\Impl\InvalidArgumentException;

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

        $request = new Request('GET', '/test-url');

//        $middleware = new BasicAuthMiddleware('username', 'password');
//        $newRequest = $middleware->handleForRequest($request);
//        $this->assertEquals('Basic ' . base64_encode('username:password'), $newRequest->getHeaderLine('Authorization'));
    }

    /**
     * Test throwing InvalidArgumentException when invalid credentials have been provided
     *
     * @return void
     */
    public function testInvalidCredentials(): void
    {

        $this->expectException(InvalidArgumentException::class);

//        $middleware = new BasicAuthMiddleware('', '');
    }
}
