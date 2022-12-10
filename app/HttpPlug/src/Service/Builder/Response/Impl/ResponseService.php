<?php

namespace Merce\RestClient\HttpPlug\src\Service\Builder\Response\Impl;

use Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\HeaderDTO;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Response\ResponseDTO;
use Merce\RestClient\HttpPlug\src\Core\Builder\Response\IResponseBuilder;
use Merce\RestClient\HttpPlug\src\Service\Builder\Response\IResponseService;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Response\ResponseStatusInfoDTO;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\Collection\HeaderCollection;
use Merce\RestClient\HttpPlug\src\Core\Builder\Exception\Response\InvalidResponseConstruction;
use Merce\RestClient\HttpPlug\src\Core\Builder\Exception\Response\InvalidResponseStatusInfoContainerConstruction;

class ResponseService implements IResponseService {

    public function __construct(
        private readonly ResponseDTO $responseDTO = new ResponseDTO()
    ) {
    }

    public function getStatusContainer(): ResponseStatusInfoDTO
    {
        $statusCode = $this->responseDTO->responseStatusInfoContainer;

        if($statusCode === null) {
            throw new InvalidResponseConstruction('Error: response status info container null exception');
        } elseif ($statusCode->statusCode === null) {
            throw new InvalidResponseStatusInfoContainerConstruction('Error: status code null exception');
        } elseif ($statusCode->protocolVersion === null) {
            throw new InvalidResponseStatusInfoContainerConstruction('Error: protocol version null exception');
        }

        return $statusCode;
    }

    public function parseHeaderLine(string $headerLine): IResponseService {

        $headerList = explode("\r\n", $headerLine);

        foreach ($headerList as $header) {
            $str = trim($header);
            if ('' !== $str) {
                if (str_starts_with(strtolower($str), 'http/')) {
                    $this->setStatusContainer($str);
                } else {
                    $this->appendHeader($str);
                }
            }
        }

        return $this;
    }

    public function setStatusContainer(string $status): IResponseService
    {
        $parts = explode(' ', $status, 3);
        if (count($parts) < 2 || !str_starts_with(strtolower($parts[0]), 'http/')) {
            throw new \InvalidArgumentException("$status is not a valid HTTP status line");
        }

        $data = [
            'statusCode' => (int) $parts[1],
            'reasonPhrase' => count($parts) > 2 ? $parts[2] : '',
            'protocolVersion' => substr($parts[0], 5)
        ];

        $this->responseDTO->responseStatusInfoContainer = new ResponseStatusInfoDTO(...$data);
        return $this;
    }

    public function getHeaderCollection(): HeaderCollection {
        $hederCollection = $this->responseDTO->headerCollection;

        return $this->responseDTO->headerCollection;
    }
    public function appendHeader(string $header): IResponseService {

        $parts = explode(':', $header, 2);

        if (2 !== count($parts)) {
            throw new \InvalidArgumentException("$header is not a valid HTTP header line");
        }

        $data = [
            'headerHead' => $parts[0],
            'headerTail' => $parts[1],
        ];

        $headerContainer = new HeaderDTO(...$data);

        $this->responseDTO->headerCollection->append($headerContainer);

        return $this;
    }

    public function getBody(): string {
        return $this->responseDTO->body;
    }
    public function setBody(string $body): IResponseService {
        $this->responseDTO->body = $body;
        return $this;
    }
}