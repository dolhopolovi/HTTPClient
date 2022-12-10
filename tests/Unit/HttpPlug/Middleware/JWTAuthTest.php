<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\HttpPlug\Middleware;

use Nyholm\Psr7\Request;
use PHPUnit\Framework\TestCase;
//use Merce\RestClient\HttpPlug\src\Core\Middleware\Impl\AuthMiddleware;
//use Merce\RestClient\HttpPlug\src\Exception\Impl\InvalidArgumentException;

/**
 *  Test AuthMiddleware class
 */
class JWTAuthTest extends TestCase
{

    /**
     * "Expect" request header equal to token
     *
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testBearerAuthListener(): void
    {

//        $request = new Request('GET', '/');
//        $middleware = AuthMiddleware::createBYToken('merce.com.secret.token');
//        $newRequest = $middleware->handleForRequest($request);
//
//        $this->assertEquals('Bearer merce.com.secret.token', $newRequest->getHeaderLine('Authorization'));
    }

    /**
     * Test throwing InvalidArgumentException when invalid access token has been provided
     *
     * @return void
     */
    public function testInvalidCredentials(): void
    {

//        $this->expectException(InvalidArgumentException::class);
//
//        $middleware = AuthMiddleware::createBYToken('');
    }
}