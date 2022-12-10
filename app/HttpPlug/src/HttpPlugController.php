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
        private readonly IMiddlewareCollection $container = new ArrayMiddlewareCollection()
    ) {
    }

    /**
     * @return ResponseInterface
     */
    public function get(RequestInterface $request): ResponseInterface
    {

        return $this->request($request);
    }


    /**
     * @param  string  $url
     * @param  array  $headers
     * @param  string  $body
     * @return ResponseInterface
     */
    public function post(RequestInterface $request): ResponseInterface
    {

        return $this->request($request);
    }

    /**
     * @return ResponseInterface
     */
    public function head(RequestInterface $request): ResponseInterface
    {

        return $this->request($request);
    }

    /**
     * @return ResponseInterface
     */
    public function patch(RequestInterface $request): ResponseInterface
    {

        return $this->request($request);
    }

    /**
     * @return ResponseInterface
     */
    public function put(RequestInterface $request): ResponseInterface
    {

        return $this->request($request);
    }

    /**
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function delete(RequestInterface $request): ResponseInterface
    {

        return $this->request($request);
    }
}