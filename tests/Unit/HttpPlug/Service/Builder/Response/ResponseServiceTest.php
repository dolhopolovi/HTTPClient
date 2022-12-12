<?php

namespace Merce\RestClient\Test\Unit\HttpPlug\Service\Builder\Response;

use ReflectionClass;
use PHPUnit\Framework\TestCase;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Response\ResponseDTO;
use Merce\RestClient\HttpPlug\src\Service\Builder\Response\IResponseService;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Response\ResponseStatusInfoDTO;
use Merce\RestClient\HttpPlug\src\Service\Builder\Response\Impl\ResponseService;
use Merce\RestClient\HttpPlug\src\Core\Builder\Exception\Response\InvalidResponseConstruction;
use Merce\RestClient\HttpPlug\src\Core\Builder\Exception\Response\InvalidResponseStatusInfoContainerConstruction;

class ResponseServiceTest extends TestCase
{
    private IResponseService $responseService;

    public function testAppendHeader() {
        $response = new ResponseService();
        $reflection = new ReflectionClass($response);

        $response->appendHeader("Test:Value");

        $prop = $reflection->getProperty('responseDTO');
        $headerCollection = $prop->getValue($response)->headerCollection;

        $reflection = new ReflectionClass($headerCollection);
        $prop = $reflection->getProperty('collection');

        [$header] = $prop->getValue($headerCollection);

        if ($header->headerHead === 'Test' && $header->headerTail === 'Value') {
            $this->assertTrue(true);
        } else
            $this->fail();
    }
}