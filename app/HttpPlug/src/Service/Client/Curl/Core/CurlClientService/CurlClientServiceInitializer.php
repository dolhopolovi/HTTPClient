<?php

namespace Merce\RestClient\HttpPlug\src\Service\Client\Curl\Core\CurlClientService;

use Psr\Http\Message\RequestInterface;
use Merce\RestClient\HttpPlug\src\Support\Arr;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Core\IClientService;
use Merce\RestClient\HttpPlug\src\Service\Builder\Curl\Request\CurlRequestBuilder;
use Merce\RestClient\HttpPlug\src\Core\Client\Impl\Curl\Exception\CurlMissingLibException;
use Merce\RestClient\HttpPlug\src\Service\Builder\Curl\Request\CurlRequestBuilderHttpMethod;

class CurlClientServiceInitializer implements IClientService {


    public function __construct() { }

    public function initRequestPack(RequestInterface $request): CurlRequestBuilder
    {
        $curlRequest = (new CurlRequestBuilder())
            ->setCURLOPTHEADER(true)
            ->setCURLOPTRETURNTRANSFER(true)
            ->setCURLOPTFAILONERROR(false)
            ->setCURLOPTCUSTOMREQUEST($request->getMethod())
            ->setCURLOPTURL($request->getUri()->__toString())
            ->setCURLOPTHTTPHEADER(Arr::flatMap($request->getHeaders()))
            ->setCURLOPTSSLVERIFYPEER(false);

        if (0 !== $version = $this->getProtocolVersion($request)) {
            $curlRequest->setCURLOPTHTTPVERSION($version);
        }

        if ($request->getUri()->getUserInfo()) {
            $curlRequest->setCURLOPTUSERPWD($request->getUri()->getUserInfo());
        }

        $curlRequest->setHttpMethod($this->initRequestPackHttpMethod($request));

        return $curlRequest;
    }

    public function initRequestPackHttpMethod(RequestInterface $request): CurlRequestBuilderHttpMethod {

        $curlRequestBuilderHttpMethod = new CurlRequestBuilderHttpMethod();

        switch (EHttpMethod::from(strtoupper($request->getMethod()))) {
            case EHttpMethod::HEAD:
                $curlRequestBuilderHttpMethod->setCURLOPTNOBODY(true);
                break;

            case EHttpMethod::GET:
                $curlRequestBuilderHttpMethod->setCURLOPTHTTPGET(true);
                break;

            case EHttpMethod::POST:
            case EHttpMethod::PUT:
            case EHttpMethod::DELETE:
            case EHttpMethod::PATCH:
            case EHttpMethod::OPTIONS:
                $body = $request->getBody();
                $bodySize = $body->getSize();
                if (0 !== $bodySize) {
                    $curlRequestBuilderHttpMethod->setCURLOPTPOSTFIELDS((string)$body);
                }
        }

        return $curlRequestBuilderHttpMethod;
    }

    public function getProtocolVersion(RequestInterface $request): int
    {
        switch ($request->getProtocolVersion()) {
            case '1.0':
                return CURL_HTTP_VERSION_1_0;
            case '1.1':
                return CURL_HTTP_VERSION_1_1;
            case '2.0':
                if (defined('CURL_HTTP_VERSION_2_0')) {
                    return CURL_HTTP_VERSION_2_0;
                }

                throw new CurlMissingLibException('Error: HTTP 2.0 requires a higher version of the libcurl library than 7.33');
            default:
                return 0;
        }
    }

    public function initHttpHandlerRequest(RequestInterface $request): CurlClientServiceExecutor
    {
        $curlRequest = $this->initRequestPack($request);

        return new CurlClientServiceExecutor($curlRequest);
    }
}