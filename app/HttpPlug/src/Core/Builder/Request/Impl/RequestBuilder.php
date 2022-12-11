<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Core\Builder\Request\Impl;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;
use Merce\RestClient\HttpPlug\src\Core\Builder\Request\IRequestBuilder;
use Merce\RestClient\HttpPlug\src\Service\Builder\Request\IRequestService;
use Merce\RestClient\HttpPlug\src\Service\Builder\Request\Impl\RequestService;
use Merce\RestClient\HttpPlug\src\Core\Builder\Exception\Request\InvalidRequestConstruction;

class RequestBuilder implements IRequestBuilder
{

    public function __construct(
        private readonly RequestFactoryInterface $factory = new Psr17Factory(),
        private readonly IRequestService $requestService = new RequestService()
    ) {
    }

    public function setMethod(EHttpMethod $method): IRequestBuilder
    {

        $this->requestService->setHttpMethod($method);
        return $this;
    }

    public function setUri(string $uri): IRequestBuilder
    {

        $this->requestService->setUri($uri);
        return $this;
    }

    public function setHeaders(array $headers): IRequestBuilder
    {

        $this->requestService->setHeaders($headers);
        return $this;
    }

    public function setBody(string $body): IRequestBuilder
    {

        $this->requestService->setBody($body);
        return $this;
    }

    /**
     * @throws InvalidRequestConstruction
     */
    public function getRequest(): RequestInterface
    {

        $state = $this->factory->createRequest($this->requestService->getHttpMethod(), $this->requestService->getUri());

        foreach ($this->requestService->getHeaderCollection() as $header) {
            $state = $state->withAddedHeader($header->headerHead, $header->headerTail);
        }

        $state->getBody()->write($this->requestService->getBody());

        return $state;
    }
}
