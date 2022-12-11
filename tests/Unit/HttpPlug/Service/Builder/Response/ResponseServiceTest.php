<?php

namespace Merce\RestClient\Test\Unit\HttpPlug\Service\Builder\Response;

use ReflectionClass;
use PHPUnit\Framework\TestCase;
use Merce\RestClient\HttpPlug\src\Service\Builder\Response\Impl\ResponseService;

class ResponseServiceTest extends TestCase
{
    public function testAppendHeader() {
        $response = new ResponseService();
        $reflection = new ReflectionClass($response);

        $response->appendHeader("Test:Value");

        $prop = $reflection->getProperty('responseDTO');
        $headerCollection = $prop->getValue($response)->headerCollection;

        $reflection = new ReflectionClass($headerCollection);
        $prop = $reflection->getProperty('collection');

        $header = $prop->getValue($headerCollection)[0];

        if ($header->headerHead === 'Test' && $header->headerTail === 'Value') {
            $this->assertTrue(true);
        } else
            $this->fail();
    }
}