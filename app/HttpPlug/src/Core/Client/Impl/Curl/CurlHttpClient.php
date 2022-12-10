<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Core\Client\Impl\Curl;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Merce\RestClient\HttpPlug\src\Core\Client\AHttpClient;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Core\IClientService;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Core\CurlClientService\CurlClientServiceInitializer;

class CurlHttpClient extends AHttpClient implements ClientInterface
{

    public function __construct(IClientService $clientService = new CurlClientServiceInitializer()) {
        parent::__construct($clientService);
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {

        $curlInitializer = $this->clientService->initHttpHandlerRequest($request);
        return $curlInitializer->execute();
    }
}
