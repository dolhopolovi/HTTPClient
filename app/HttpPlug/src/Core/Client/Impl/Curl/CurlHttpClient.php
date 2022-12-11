<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Core\Client\Impl\Curl;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Merce\RestClient\HttpPlug\src\Support\Arr;
use Merce\RestClient\HttpPlug\src\Core\Client\AHttpClient;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Factory\IFactoryCurlBuilder;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Factory\Impl\FactoryCurlBuilderFactory;

class CurlHttpClient extends AHttpClient implements ClientInterface
{

    public function __construct(
        IFactoryCurlBuilder $curlHandler = new FactoryCurlBuilderFactory(),

    ) {
        parent::__construct($curlHandler);
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {

        $curlInitializer = $this->clientService->initHttpHandlerRequest($request);
        return $curlInitializer->execute();
    }
}
