<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\Middleware;

use Nyholm\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Merce\RestClient\HttpPlug\src\Middleware\Impl\JWTAuthMiddleware;
use Merce\RestClient\HttpPlug\src\Exception\Impl\InvalidArgumentException;

/**
 *  Test JWTAuthMiddleware class
 */
class JWTAuthTest extends TestCase
{

    /**
     * @return void
     */
    public function testBearerAuthListener(): void
    {

        $request = new Request('GET', '/');
        $middleware = JWTAuthMiddleware::createBYToken('merce.com.secret.token');
        $newRequest = null;
        $middleware->handleRequest($request, function ($request) use (&$newRequest) {

            $newRequest = $request;
        });

        $this->assertEquals('Bearer merce.com.secret.token', $newRequest->getHeaderLine('Authorization'));
    }

    /**
     * Test throwing InvalidArgumentException when invalid access token has been provided
     *
     * @return void
     */
    public function testInvalidCredentials(): void
    {

        $this->expectException(InvalidArgumentException::class);

        $middleware = JWTAuthMiddleware::createBYToken('');
    }
}