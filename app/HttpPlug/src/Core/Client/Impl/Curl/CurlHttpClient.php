<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Core\Client\Impl\Curl;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Merce\RestClient\HttpPlug\src\Support\Arr;
use Merce\RestClient\HttpPlug\src\Core\Client\AHttpClient;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Factory\IFactoryCurlBuilder;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Factory\Impl\FactoryCurlBuilderFactory;

class CurlHttpClient extends AHttpClient implements ClientInterface
{

    public function __construct(
        IFactoryCurlBuilder $factoryCurlBuilder = new FactoryCurlBuilderFactory(),

    ) {

        parent::__construct($factoryCurlBuilder);
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {

        return $this->factoryCurlBuilder->init()->setGenericCurlExtraParamPack()->setCURLOPTCUSTOMREQUEST($request->getMethod())->setCURLOPTURL($request->getUri()->__toString())
                                        ->setCURLOPTHTTPHEADER(Arr::flatMap($request->getHeaders()))->setCURLOPTSSLVERIFYPEER()->setCURLOPTSTDERR()->buildExecutionContext()
                                        ->execute();
    }
}
