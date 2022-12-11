<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Core\Builder\Response\Impl;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Merce\RestClient\HttpPlug\src\Core\Builder\Response\IResponseBuilder;
use Merce\RestClient\HttpPlug\src\Service\Builder\Response\IResponseService;
use Merce\RestClient\HttpPlug\src\Service\Builder\Response\Impl\ResponseService;

class ResponseBuilder implements IResponseBuilder
{

    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory = new Psr17Factory(),
        private readonly IResponseService $responseService = new ResponseService()
    ) {

    }

    public function parseHeaderLine(string $headerLine): IResponseBuilder {

        $this->responseService->parseHeaderLine($headerLine);
        return $this;
    }

    public function setBody(string $input): IResponseBuilder {

        $this->responseService->setBody($input);
        return $this;
    }

    public function getResponse(): ResponseInterface
    {

        $response = $this->responseFactory->createResponse()
            ->withStatus($this->responseService->getStatusContainer()->statusCode, $this->responseService->getStatusContainer()->humanizedReponse)
            ->withProtocolVersion($this->responseService->getStatusContainer()->protocolVersion);

        foreach ($this->responseService->getHeaderCollection() as $header) {
            $response = $response->withAddedHeader($header->headerHead, $header->headerTail);
        }

        $response->getBody()->write($this->responseService->getBody());
        $response->getBody()->rewind();

        return $response;
    }
}

