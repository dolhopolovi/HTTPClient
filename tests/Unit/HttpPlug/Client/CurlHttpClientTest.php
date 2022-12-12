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
}