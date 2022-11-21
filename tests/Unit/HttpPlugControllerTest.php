<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit;

use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Merce\RestClient\HttpPlug\src\HttpPlugController;
use Merce\RestClient\HttpPlug\src\Client\Impl\Curl\CurlHttpClient;

/**
 * Test HttpPlugController class
 */
class HttpPlugControllerTest extends TestCase
{

    private CurlHttpClient $client;

    private HttpPlugController $browser;

    /**
     * Test basic http methods
     *
     * @dataProvider provideMethods
     * @param $method
     * @param $content
     * @return void
     */
    public function testBasicMethods($method, $content): void
    {

        $response = new Response(200, [], 'body-data');
        $headers = ['X-Example' => 'example-header'];

        $this->client->expects($this->once())->method('sendRequest')->willReturn($response);

        $actual = $this->browser->$method('http://google.com/', $headers, $content);

        $this->assertInstanceOf(ResponseInterface::class, $actual);
        $this->assertEquals($response->getBody()->__toString(), $actual->getBody()->__toString());
    }

    /**
     * Basic http methods array
     *
     * @return string[][]
     */
    public function provideMethods(): array
    {

        return [
            ['get', ''],
            ['head', ''],
            ['post', 'content'],
            ['put', 'content'],
            ['patch', 'content'],
            ['delete', 'content'],
        ];
    }

    /**
     * setting up data for the test purpose
     *
     * @return void
     */
    protected function setUp(): void
    {

        $this->client = $this->getMockBuilder(CurlHttpClient::class)->disableOriginalConstructor()->getMock();

        $this->browser = new HttpPlugController($this->client, new Psr17Factory());
    }
}