<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Merce\RestClient\HttpPlug\src\Service\Middleware\MiddlewareService;
use Merce\RestClient\HttpPlug\src\DTO\Middleware\Collection\IMiddlewareCollection;
use Merce\RestClient\HttpPlug\src\DTO\Middleware\Collection\Impl\ArrayMiddlewareCollection;

class HttpPlugController
{

    public function __construct(
        private readonly ClientInterface $client,
        private readonly RequestFactoryInterface $requestFactory = new Psr17Factory(),
        private readonly IMiddlewareHandler $handler = new StackMiddlewareHandler()
    ) {
    }

    /**
     * @param  string  $url
     * @param  array  $headers
     * @return ResponseInterface
     */
    public function get(string $url, array $headers = []): ResponseInterface
    {

        return $this->request('GET', $url, $headers);
    }

    /**
     * @param  string  $method
     * @param  string  $url
     * @param  array  $headers
     * @param  string  $body
     * @return ResponseInterface
     */
    private function request(string $method, string $url, array $headers = [], string $body = ''): ResponseInterface
    {

        $request = $this->createRequest($method, $url, $headers, $body);

        return $this->sendRequest($request);
    }

    /**
     * @param  string  $method
     * @param  string  $url
     * @param  array  $headers
     * @param  string  $body
     * @return RequestInterface
     */
    private function createRequest(string $method, string $url, array $headers, string $body): RequestInterface
    {

        $request = $this->requestFactory->createRequest($method, $url);
        $request->getBody()->write($body);
        foreach ($headers as $name => $value) {
            $request = $request->withAddedHeader($name, $value);
        }

        return $request;
    }

    /**
     * @param  RequestInterface  $request
     * @return ResponseInterface
     * @throws ClientException
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {

        $requestChainLast = function (RequestInterface $request, callable $responseChain) {

            $response = $this->client->sendRequest($request);
            $responseChain($request, $response);
        };
        $responseChainLast = function (RequestInterface $request, ResponseInterface $response) {

            $this->lastRequest = $request;
            $this->lastResponse = $response;
        };

        $callbackChain = $this->handler->resolve($requestChainLast, $responseChainLast);
        $callbackChain($request);

        return $this->lastResponse;
    }

    /**
     * @param  string  $url
     * @param  array  $headers
     * @param  string  $body
     * @return ResponseInterface
     */
    public function post(string $url, array $headers = [], string $body = ''): ResponseInterface
    {

        return $this->request('POST', $url, $headers, $body);
    }

    /**
     * @param  string  $url
     * @param  array  $headers
     * @return ResponseInterface
     */
    public function head(string $url, array $headers = []): ResponseInterface
    {

        return $this->request('HEAD', $url, $headers);
    }

    /**
     * @param  string  $url
     * @param  array  $headers
     * @param  string  $body
     * @return ResponseInterface
     */
    public function patch(string $url, array $headers = [], string $body = ''): ResponseInterface
    {

        return $this->request('PATCH', $url, $headers, $body);
    }

    /**
     * @param  string  $url
     * @param  array  $headers
     * @param  string  $body
     * @return ResponseInterface
     */
    public function put(string $url, array $headers = [], string $body = ''): ResponseInterface
    {

        return $this->request('PUT', $url, $headers, $body);
    }

    /**
     * @param  string  $url
     * @param  array  $headers
     * @param  string  $body
     * @return ResponseInterface
     */
    public function delete(string $url, array $headers = [], string $body = ''): ResponseInterface
    {

        return $this->request('DELETE', $url, $headers, $body);
    }
}