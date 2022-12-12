<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\AuthTokenPlug\TokenManager;

use Nyholm\Psr7\Stream;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Psr\Http\Client\ClientExceptionInterface;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;
use Merce\RestClient\AuthTokenPlug\src\DTO\JWTToknen\JWTAuthData;
use Merce\RestClient\HttpPlug\src\Core\Client\Impl\Curl\CurlHttpClient;
use Merce\RestClient\HttpPlug\src\Core\Builder\Request\Impl\RequestBuilder;
use Merce\RestClient\AuthTokenPlug\src\Core\TokenController\JWTToken\AutoJWTTokenController;

/**
 * Test JWTTokenManagerTest class
 */
class JWTTokenManagerTest extends TestCase
{

    private StreamInterface $mockStream;

    private ResponseInterface $mockResponse;

    private ClientInterface $mockClient;

    /**
     * "Expect" expected token equal to actual token
     *
     * @return void
     * @throws ClientExceptionInterface
     * @throws InvalidArgumentException
     */
    public function testJWTTokenManagerTokenEqual(): void
    {

        $jwtAuthData = [
            'request'  => (new RequestBuilder())->setUri('/test2.login')->setMethod(EHttpMethod::GET)->getRequest(),
            'username' => 'username',
            'password' => 'password',
        ];

        $this->mockStream->expects($this->any())->method('getContents')->willReturn(
            'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c'
        );
        $this->mockResponse->expects($this->any())->method('getStatusCode')->willReturn(200);

        $jwtTokenManager = new AutoJWTTokenController(new JWTAuthData(...$jwtAuthData), $this->mockClient);

        $request = $jwtTokenManager->authenticate((new RequestBuilder())->setUri('/test2.login')->setMethod(EHttpMethod::GET)->getRequest());

        $this->assertEquals(
            'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c',
            $request->getHeaderLine('Authorization')
        );
    }

    /**
     * "Expect" expected token is null when the actual token expires
     *
     * @return void
     * @throws ClientExceptionInterface
     * @throws InvalidArgumentException
     */
    public function testJWTTokenManagerTokenExpire(): void
    {

        $jwtAuthData = [
            'request'  => (new RequestBuilder())->setUri('/test.login')->setMethod(EHttpMethod::GET)->getRequest(),
            'username' => 'username_token_exp',
            'password' => 'password_toke_exp',
        ];

        $payload = json_encode(['name' => 'Jan Kowalski', 'exp' => time() + 5]);
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $token = ".$base64UrlPayload.";

        $this->mockStream->expects($this->any())->method('getContents')->willReturn($token);
        $this->mockResponse->expects($this->any())->method('getStatusCode')->willReturnOnConsecutiveCalls(200, 401);

        $jwtTokenManager = new AutoJWTTokenController(new JWTAuthData(...$jwtAuthData), $this->mockClient);

        $request = $jwtTokenManager->authenticate((new RequestBuilder())->setUri('/test.login')->setMethod(EHttpMethod::GET)->getRequest());

        $this->assertEquals("Bearer .$base64UrlPayload.", $request->getHeaderLine('Authorization'));

        sleep(6);

        $request = $jwtTokenManager->authenticate((new RequestBuilder())->setUri('/test.login')->setMethod(EHttpMethod::GET)->getRequest());

        $this->assertEquals(null, $request->getHeaderLine('Authorization') ? : null);
    }

    /**
     * "Expect" expected token equal to null
     *
     * @return void
     * @throws ClientExceptionInterface
     * @throws InvalidArgumentException
     */
    public function testJWTTokenManagerUnauthenticated(): void
    {

        $jwtAuthData = [
            'request'  => (new RequestBuilder())->setUri('/test1.login')->setMethod(EHttpMethod::GET)->getRequest(),
            'username' => 'username_auth',
            'password' => 'password_auth',
        ];

        $this->mockResponse->expects($this->any())->method('getStatusCode')->willReturn(401);

        $jwtTokenManager = new AutoJWTTokenController(new JWTAuthData(...$jwtAuthData), $this->mockClient);

        $request = $jwtTokenManager->authenticate((new RequestBuilder())->setUri('/test1.login')->setMethod(EHttpMethod::GET)->getRequest());

        $this->assertEquals(null, $request->getHeaderLine('Authorization') ? : null);
    }

    /**
     * Setting up data for the test purpose
     *
     * @return void
     */
    public function setUp(): void
    {

        parent::setUp();

        $this->mockStream = $this->getMockBuilder(Stream::class)->disableOriginalConstructor()->getMock();

        $this->mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $this->mockResponse->expects($this->any())->method('getBody')->willReturn($this->mockStream);

        $this->mockClient = $this->getMockBuilder(CurlHttpClient::class)->disableOriginalClone()->getMock();
        $this->mockClient->expects($this->any())->method('sendRequest')->willReturn($this->mockResponse);
    }
}