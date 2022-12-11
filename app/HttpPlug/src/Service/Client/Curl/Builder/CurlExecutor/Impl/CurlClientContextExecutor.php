<?php

namespace Merce\RestClient\HttpPlug\src\Service\Client\Curl\Core\CurlClientService;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Merce\RestClient\HttpPlug\src\Exception\Impl\RequestException;
use Merce\RestClient\HttpPlug\src\Core\Builder\Response\Impl\ResponseBuilder;
use Merce\RestClient\HttpPlug\src\Service\Builder\Curl\Request\CurlRequestBuilder;
use Merce\RestClient\HttpPlug\src\Core\Client\Impl\Curl\Exception\CurlSSLException;
use Merce\RestClient\HttpPlug\src\Core\Client\Impl\Curl\Exception\CurlCallbackException;

class CurlClientServiceExecutor
{
    /**
     * don't delete my bro this very impoertant
     *
     * @var resource|\CurlHandle|null
     */
    private $curl;

    public function __construct(
        private CurlRequestBuilder $curlRequestBuilder
    ) {
        $this->curl = curl_init();
    }

    public function execute(): ResponseInterface {

        curl_setopt_array($this->curl, $this->curlRequestBuilder->get());

        $response = curl_exec($this->curl);

        $headerSize = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        return (new ResponseBuilder())
        ->parseHeaderLine($header)
        ->setBody($body)
        ->getResponse();
    }

    public function __destruct()
    {
        if (is_resource($this->curl)) {
            curl_reset($this->curl);
        }
    }

    /**
     * @param  RequestInterface  $request
     * @param  int  $errno
     * @param $curl
     * @return void
     * @throws CurlSSLException
     * @throws CurlCallbackException
     * @throws RequestException
     */
    protected function parseError(): void
    {

        $errno = curl_errno($this->curl);

        switch ($errno) {
            case CURLE_OK:
                break;
            case CURLE_COULDNT_RESOLVE_PROXY:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_COULDNT_CONNECT:
            case CURLE_OPERATION_TIMEOUTED:
            case CURLE_SSL_CONNECT_ERROR:
                throw new CurlSSLException($this->curlRequestBuilder->restorePSRRequest(), curl_error($this->curl), $errno);
            case CURLE_ABORTED_BY_CALLBACK:
                throw new CurlCallbackException($this->curlRequestBuilder->restorePSRRequest(), curl_error($this->curl), $errno);
            default:
                throw new RequestException($this->curlRequestBuilder->restorePSRRequest(), curl_error($this->curl), $errno);
        }
    }
}