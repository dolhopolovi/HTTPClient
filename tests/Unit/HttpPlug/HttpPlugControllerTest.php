<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\HttpPlug;

use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Merce\RestClient\HttpPlug\src\HttpPlugController;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;
use Merce\RestClient\HttpPlug\src\Core\Client\Impl\Curl\CurlHttpClient;
use Merce\RestClient\HttpPlug\src\Core\Builder\Request\Impl\RequestBuilder;

/**
 * Test HttpPlugController class
 */
class HttpPlugControllerTest extends TestCase
{

    private CurlHttpClient $client;

    private HttpPlugController $httpPlugController;

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

        $request = (new RequestBuilder())->setUri('http://google.com/')->setMethod(EHttpMethod::from(strtoupper($method)))->setHeaders($headers)->setBody($content)->getRequest();

        $actual = $this->httpPlugController->$method($request);

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
     * Setting up data for the test purpose
     *
     * @return void
     */
    protected function setUp(): void
    {

        $this->client = $this->getMockBuilder(CurlHttpClient::class)->disableOriginalConstructor()->getMock();

        $this->httpPlugController = new HttpPlugController(client: $this->client);
    }
}