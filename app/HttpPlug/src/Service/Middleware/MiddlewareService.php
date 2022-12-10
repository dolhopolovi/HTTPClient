<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Service\Middleware;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Merce\RestClient\HttpPlug\src\DTO\Middleware\Collection\IMiddlewareCollection;

class MiddlewareService
{

    public function __construct(private readonly IMiddlewareCollection $container, private ClientInterface $client) {

    }

    /**
     * @throws ClientExceptionInterface
     */
    public function sendRequestWithMiddlewares(RequestInterface $request): ResponseInterface {
        $preparedRequest = $this->passRequestThroughMiddlewares($request);
        $response = $this->client->sendRequest($preparedRequest);
        return $this->passResponseThroughMiddlewares($response, $request);
    }

    private function passRequestThroughMiddlewares(RequestInterface $request) : RequestInterface
    {
        $middlewaresIterator = $this->container->getForwardIterator();

        foreach ($middlewaresIterator as $middleware) {
            $request = $middleware->handleForRequest($request);
        }
        return $request;
    }

    private function passResponseThroughMiddlewares(ResponseInterface $response, RequestInterface $request) : ResponseInterface
    {
        $middlewaresIterator = $this->container->getReverseIterator();

        foreach ($middlewaresIterator as $middleware) {
            $response = $middleware->handleForResponse($response, $request);
        }
        return $response;
    }



}
