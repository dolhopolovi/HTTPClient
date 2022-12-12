<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\HttpPlug\Service\Builder\Response;

use ReflectionClass;
use ReflectionException;
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

    /**
     * @throws ReflectionException
     */
    public function testAppendHeader()
    {

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
        } else {
            $this->fail();
        }
    }

    /**
     * @throws ReflectionException
     */
    public function testSetStatusContainer(): void
    {

        $statusLine = "HTTP/1.1 200 OK";

        $reflection = new ReflectionClass($this->responseService);
        $this->responseService->setStatusContainer($statusLine);

        $prop = $reflection->getProperty('responseDTO');

        /* @var ResponseStatusInfoDTO $responseStatusInfoDTO */
        $responseStatusInfoDTO = $prop->getValue($this->responseService)->responseStatusInfoContainer;

        $responseStatusInfoDTOExpected = new ResponseStatusInfoDTO(200, 'OK', '1.1');

        if ($responseStatusInfoDTO == $responseStatusInfoDTOExpected) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    /**
     * @throws InvalidResponseStatusInfoContainerConstruction
     */
    public function testInvalidResponseConstructionStatusInfo(): void
    {

        $this->expectException(InvalidResponseConstruction::class);

        $this->responseService->getStatusContainer();
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseConstruction
     */
    public function testInvalidResponseStatusInfoContainerConstructionStatusCode(): void
    {

        $this->expectException(InvalidResponseStatusInfoContainerConstruction::class);
        $this->expectErrorMessage('Error: status code null exception');

        $reflection = new ReflectionClass($this->responseService);
        $inst = $reflection->newInstanceWithoutConstructor();

        $prop = $reflection->getProperty('responseDTO');
        $responseDTO = new ResponseDTO();
        $responseDTO->responseStatusInfoContainer = new ResponseStatusInfoDTO(humanizedReponse: 'OK');
        $prop->setValue($inst, $responseDTO);

        $inst->getStatusContainer();
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseConstruction
     */
    public function testInvalidResponseStatusInfoContainerConstructionProtocolVersion(): void
    {

        $this->expectException(InvalidResponseStatusInfoContainerConstruction::class);
        $this->expectErrorMessage('Error: protocol version null exception');

        $reflection = new ReflectionClass($this->responseService);
        $inst = $reflection->newInstanceWithoutConstructor();

        $prop = $reflection->getProperty('responseDTO');
        $responseDTO = new ResponseDTO();
        $responseDTO->responseStatusInfoContainer = new ResponseStatusInfoDTO(200, 'OK');
        $prop->setValue($inst, $responseDTO);

        $inst->getStatusContainer();
    }

    public function setUp(): void
    {

        parent::setUp(); // TODO: Change the autogenerated stub

        $this->responseService = new ResponseService();
    }
}