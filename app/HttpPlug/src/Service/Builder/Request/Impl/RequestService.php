<?php

namespace Merce\RestClient\HttpPlug\src\Service\Builder\Request\Impl;

use Nyholm\Psr7\Uri;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\HeaderDTO;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Request\RequestDTO;
use Merce\RestClient\HttpPlug\src\Service\Builder\Request\IRequestService;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\Collection\HeaderCollection;
use Merce\RestClient\HttpPlug\src\Core\Builder\Exception\Request\InvalidRequestConstruction;

class RequestService implements IRequestService {

    public function __construct(
        private readonly RequestDTO $requestDTO = new RequestDTO()
    ) {
    }

    public function getUri(): Uri
    {
        $uri = $this->requestDTO->uri;

        if($uri === null) {
            throw new InvalidRequestConstruction('Error: request url null exception');
        }

        return $uri;
    }
    public function setUri(string $uri): IRequestService
    {
        $this->requestDTO->uri = new Uri($uri);
        return $this;
    }

    public function getHttpMethod(): string
    {
        $httpMethod = $this->requestDTO->httpMethod;

        if($httpMethod === null) {
            throw new InvalidRequestConstruction('Error: request http method null exception');
        }

        return $httpMethod->value;
    }
    public function setHttpMethod(EHttpMethod $httpMethod): IRequestService
    {
        $this->requestDTO->httpMethod = $httpMethod;
        return $this;
    }


    public function getHeaderCollection(): HeaderCollection
    {
        return $this->requestDTO->headerCollection;
    }

    public function setHeaders(array $headers): IRequestService
    {
        $result = new HeaderCollection();

        foreach ($headers as $headerHead => $headerTail) {

            $header = new HeaderDTO($headerHead, $headerTail);
            $result->append($header);
        }

        $this->requestDTO->headerCollection = $result;

        return $this;
    }

    public function getBody(): string
    {
        return $this->requestDTO->body;
    }

    public function setBody(string $body): IRequestService
    {
        $this->requestDTO->body = $body;

        return $this;
    }
}