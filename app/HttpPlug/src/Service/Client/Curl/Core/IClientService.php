<?php

namespace Merce\RestClient\HttpPlug\src\Service\Client\Curl\Core;

use Psr\Http\Message\RequestInterface;
use Merce\RestClient\HttpPlug\src\Service\Builder\Curl\Request\CurlRequestBuilder;
use Merce\RestClient\HttpPlug\src\Service\Builder\Curl\Request\CurlRequestBuilderHttpMethod;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Core\CurlClientService\CurlClientServiceExecutor;

interface IClientService
{
    public function initRequestPack(RequestInterface $request): CurlRequestBuilder;
    public function initRequestPackHttpMethod(RequestInterface $request): CurlRequestBuilderHttpMethod;
    public function getProtocolVersion(RequestInterface $request): int;
    public function initHttpHandlerRequest(RequestInterface $request): CurlClientServiceExecutor;
}