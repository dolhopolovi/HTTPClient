<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\HttpPlug\Service\Builder\Request;

use PHPUnit\Framework\TestCase;
use Merce\RestClient\HttpPlug\src\Service\Builder\Request\IRequestService;
use Merce\RestClient\HttpPlug\src\Service\Builder\Request\Impl\RequestService;
use Merce\RestClient\HttpPlug\src\Core\Builder\Exception\Request\InvalidRequestConstruction;

class RequestServiceTest extends TestCase
{

    private IRequestService $requestService;

    public function testGetHttpMethod()
    {

        $this->expectException(InvalidRequestConstruction::class);
        $this->expectErrorMessage('Error: request http method null exception');

        $this->requestService->getHttpMethod();
    }

    public function testGetUri()
    {

        if ($this->requestService->getHeaderCollection()->isEmpty()) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    public function testGetHeaderCollection()
    {

        $this->expectException(InvalidRequestConstruction::class);
        $this->expectErrorMessage('Error: request url null exception');

        $this->requestService->getUri();
    }

    public function setUp(): void
    {

        parent::setUp();

        $this->requestService = new RequestService();
    }
}