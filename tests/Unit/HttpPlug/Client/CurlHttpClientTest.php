<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\HttpPlug\Client;

use ReflectionMethod;
use Nyholm\Psr7\Stream;
use Nyholm\Psr7\Request;
use ReflectionException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientExceptionInterface;
use Merce\RestClient\HttpPlug\src\Exception\Impl\ClientException;
use Merce\RestClient\HttpPlug\src\Core\Client\Impl\Curl\CurlHttpClient;

/**
 * Test CurlHttpClient class
 */
class CurlHttpClientTest extends TestCase
{

    /**
     * Test throwing ClientExceptionInterface when invalid host provided
     *
     * @dataProvider provideInvalidHosts
     * @throws ClientExceptionInterface
     */
    public function testSendToInvalidUrl($host, $client): void
    {

        $this->expectException(ClientException::class);

        $request = new Request('GET', 'http://' . $host . ':8000');

        /** @var ClientInterface $client */
        $client = new $client();
        $client->sendRequest($request);
    }

    /**
     * Invalid hosts array
     *
     * @return string[][]
     */
    public function provideInvalidHosts(): array
    {

        return [
            ['address', CurlHttpClient::class],
            ['address.merce.http.rest_client', CurlHttpClient::class],
        ];
    }

    /**
     * "Expect" large stream should be rewinded
     *
     * @return void
     * @throws ReflectionException
     */
    public function testRewindLargeStream(): void
    {

        $client = $this->createMock(CurlHttpClient::class);
        $options = new ReflectionMethod(CurlHttpClient::class, 'setOptionsFromRequest');

        $content = 'abcdef';
        while (strlen($content) < 1024 * 1024 + 100) {
            $content .= '123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890';
        }

        $length = strlen($content);
        $body = Stream::create($content);
        $body->seek(40);
        $request = new Request('POST', 'http://foo.com', body: $body);
        $options = $options->invoke($client, curl_init(), $request);

        static::assertTrue(str_contains($options[CURLOPT_READFUNCTION](null, null, $length), 'abcdef'), 'Stream was not rewinded');
    }

    /**
     * "Expect" small stream should be rewinded
     *
     * @return void
     * @throws ReflectionException
     */
    public function testRewindStream(): void
    {

        $client = $this->createMock(CurlHttpClient::class);
        $options = new ReflectionMethod(CurlHttpClient::class, 'setOptionsFromRequest');

        $content = 'abcdef';
        $body = Stream::create($content);
        $body->seek(3);
        $request = new Request('POST', 'http://foo.com', body: $body);
        $options = $options->invoke($client, curl_init(), $request);

        static::assertEquals('abcdef', $options[CURLOPT_POSTFIELDS]);
    }
}