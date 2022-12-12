<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\HttpPlug\Service\Client\Curl;

use ReflectionClass;
use Nyholm\Psr7\Stream;
use ReflectionException;
use PHPUnit\Framework\TestCase;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\ICurlBuilder;
use Merce\RestClient\HttpPlug\src\Core\Builder\Request\Impl\RequestBuilder;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Impl\CurlBuilder;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl\GenericCurlExtraParamPack;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Partials\Logger\FileLoggerService;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Exception\InvalidCurlRequestConstruction;

class CurlBuilderTest extends TestCase
{

    public function testSetGenericCurlExtraParamPack(): void
    {

        $genericCurlRequestDTOExpected = (new GenericCurlExtraParamPack())->setCURLOPTVERBOSE(true)->setCURLOPTFAILONERROR(false)->setCURLOPTRETURNTRANSFER(true)->setCURLOPTHEADER(
            true
        )->get();

        $curlBuilder = new CurlBuilder();
        $reflection = new ReflectionClass($curlBuilder);

        $curlBuilder->setGenericCurlExtraParamPack();

        $prop = $reflection->getProperty('genericCurlRequestDTO');

        $genericCurlRequestDTOActual = $prop->getValue($curlBuilder)->get();

        $this->assertEquals($genericCurlRequestDTOExpected, $genericCurlRequestDTOActual);
    }

    /**
     * @dataProvider provideHttpMethodData
     * */
    public function testSetHttpMethod(string $string, ?Stream $body, array $expected): void
    {

        $curlBuilder = new CurlBuilder();
        $reflection = new ReflectionClass($curlBuilder);

        $curlBuilder->setHttpMethod($string, $body);

        $prop = $reflection->getProperty('genericCurlRequestDTO');
        $genericCurlRequestDTOHttpMethodActual = $prop->getValue($curlBuilder)->get();

        $this->assertEquals($genericCurlRequestDTOHttpMethodActual, $expected);
    }

    /**
     * Http method data array
     */
    public function provideHttpMethodData(): array
    {

        return [
            ['HEAD', null, [CURLOPT_NOBODY => true]],
            ['GET', null, [CURLOPT_HTTPGET => true]],
            ['POST', Stream::create('abcabcabcabcabcabcabc'), [CURLOPT_POSTFIELDS => (string)Stream::create('abcabcabcabcabcabcabc')]],
            ['PUT', Stream::create('abcabcabcabcabcabcabc'), [CURLOPT_POSTFIELDS => (string)Stream::create('abcabcabcabcabcabcabc')]],
            ['DELETE', Stream::create('abcabcabcabcabcabcabc'), [CURLOPT_POSTFIELDS => (string)Stream::create('abcabcabcabcabcabcabc')]],
            ['PATCH', Stream::create('abcabcabcabcabcabcabc'), [CURLOPT_POSTFIELDS => (string)Stream::create('abcabcabcabcabcabcabc')]],
            ['OPTIONS', null, []],
        ];
    }

    /**
     * @dataProvider provideCurlOptCheckData
     *
     * @throws ReflectionException
     * @throws ReflectionException
     */
    public function testCurlOptCheckFlagListFail(ICurlBuilder $builder)
    {

        $this->expectException(InvalidCurlRequestConstruction::class);

        $reflection = new ReflectionClass($builder);

        $method = $reflection->getMethod('curlOptCheckFlagList');
        $method->invoke($builder);
    }

    public function provideCurlOptCheckData(): array
    {

        return [
            [
                (new CurlBuilder())->setGenericCurlExtraParamPack()->setCURLOPTURL('http://example.com')->setCURLOPTSTDERR(new FileLoggerService())->setCURLOPTCUSTOMREQUEST('GET'),
            ],
            [
                (new CurlBuilder())->setGenericCurlExtraParamPack()->setCURLOPTURL('http://example.com')->setCURLOPTSTDERR(new FileLoggerService())->setCURLOPTSSLVERIFYPEER(),
            ],
            [
                (new CurlBuilder())->setCURLOPTURL('http://example.com')->setCURLOPTSTDERR(new FileLoggerService())->setCURLOPTCUSTOMREQUEST('GET')->setCURLOPTSSLVERIFYPEER(),
            ],
        ];
    }

    public function testCurlOptCheckFlagListOK()
    {

        (new CurlBuilder())->setGenericCurlExtraParamPack()->setCURLOPTURL('http://example.com')->setCURLOPTSTDERR(new FileLoggerService())->setCURLOPTCUSTOMREQUEST('GET')
                           ->setCURLOPTSSLVERIFYPEER()->buildRequest();

        $this->assertTrue(true);
    }

    public function testBuildRequest()
    {

        $requestActual = (new CurlBuilder())->setGenericCurlExtraParamPack()->setCURLOPTURL('http://example.com')->setCURLOPTSTDERR(new FileLoggerService())
                                            ->setCURLOPTCUSTOMREQUEST('GET')->setCURLOPTSSLVERIFYPEER()->buildRequest()->getPSRRequest();

        $requestExpected = (new RequestBuilder())->setUri('http://example.com')->setMethod(EHttpMethod::GET)->getRequest();

        if ($requestActual->getUri()->__toString() === $requestExpected->getUri()->__toString() && $requestExpected->getMethod() === $requestActual->getMethod()) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }
}