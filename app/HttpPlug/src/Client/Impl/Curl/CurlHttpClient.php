<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Client\Impl\Curl;

use CurlHandle;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Merce\RestClient\HttpPlug\src\Support\Arr;
use Merce\RestClient\HttpPlug\src\Client\EHttpMethod;
use Merce\RestClient\HttpPlug\src\Client\AHttpClient;
use Merce\RestClient\HttpPlug\src\Message\ResponseBuilder;
use Merce\RestClient\HttpPlug\src\Exception\Impl\RequestException;
use Merce\RestClient\HttpPlug\src\Client\Impl\Curl\Exception\CurlSSLException;
use Merce\RestClient\HttpPlug\src\Client\Impl\Curl\Exception\CurlCallbackException;
use Merce\RestClient\HttpPlug\src\Client\Impl\Curl\Exception\CurlMissingLibException;
use Merce\RestClient\HttpPlug\src\Client\Impl\Curl\Exception\CurlInitHandlerException;

use function strlen;
use function defined;

class CurlHttpClient extends AHttpClient implements ClientInterface
{

    /**
     * @param  RequestInterface  $request
     * @return ResponseInterface
     * @throws CurlInitHandlerException
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {

        $curl = $this->initCurlHandler();
        $responseBuilder = $this->prepare($curl, $request);

        try {
            curl_exec($curl);
            $this->parseError($request, curl_errno($curl), $curl);
        }
        finally {
            $this->releaseCurlHandler($curl);
        }

        return $responseBuilder->getResponse();
    }

    /**
     * @return CurlHandle
     * @throws CurlInitHandlerException
     */
    protected function initCurlHandler(): CurlHandle
    {

        $curl = curl_init();
        if ($curl === false) {
            throw new CurlInitHandlerException('Error: curl init failed');
        }

        return $curl;
    }

    /**
     * @param  CurlHandle  $curl
     * @param  RequestInterface  $request
     * @return ResponseBuilder
     */
    protected function prepare(CurlHandle $curl, RequestInterface $request): ResponseBuilder
    {

        if (defined('CURLOPT_PROTOCOLS')) {
            curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
            curl_setopt($curl, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
        }

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);

        $this->setOptionsFromRequest($curl, $request);

        $responseBuilder = new ResponseBuilder($this->responseFactory);
        curl_setopt($curl, CURLOPT_HEADERFUNCTION, function ($ch, $data) use ($responseBuilder) {

            $str = trim($data);
            if ('' !== $str) {
                if (str_starts_with(strtolower($str), 'http/')) {
                    $responseBuilder->setStatus($str);
                } else {
                    $responseBuilder->addHeader($str);
                }
            }

            return strlen($data);
        });

        curl_setopt($curl, CURLOPT_WRITEFUNCTION, function ($ch, $data) use ($responseBuilder) {

            return $responseBuilder->writeBody($data);
        });

        return $responseBuilder;
    }

    /**
     * @param  CurlHandle  $curl
     * @param  RequestInterface  $request
     * @return array
     */
    private function setOptionsFromRequest(CurlHandle $curl, RequestInterface $request): array
    {

        $options = [
            CURLOPT_CUSTOMREQUEST => $request->getMethod(),
            CURLOPT_URL           => $request->getUri()->__toString(),
            CURLOPT_HTTPHEADER    => Arr::flatMap($request->getHeaders()),
        ];

        if (0 !== $version = $this->getProtocolVersion($request)) {
            $options[CURLOPT_HTTP_VERSION] = $version;
        }

        if ($request->getUri()->getUserInfo()) {
            $options[CURLOPT_USERPWD] = $request->getUri()->getUserInfo();
        }

        switch (EHttpMethod::from(strtoupper($request->getMethod()))) {
            case EHttpMethod::HEAD:
                $options[CURLOPT_NOBODY] = true;
                break;

            case EHttpMethod::GET:
                $options[CURLOPT_HTTPGET] = true;
                break;

            case EHttpMethod::POST:
            case EHttpMethod::PUT:
            case EHttpMethod::DELETE:
            case EHttpMethod::PATCH:
            case EHttpMethod::OPTIONS:
                $body = $request->getBody();
                $bodySize = $body->getSize();
                if (0 !== $bodySize) {
                    if ($body->isSeekable()) {
                        $body->rewind();
                    }
                    if (null === $bodySize || $bodySize > 1024 * 1024) {
                        $options[CURLOPT_UPLOAD] = true;
                        if (null !== $bodySize) {
                            $options[CURLOPT_INFILESIZE] = $bodySize;
                        }
                        $options[CURLOPT_READFUNCTION] = function ($ch, $fd, $length) use ($body) {

                            return $body->read($length);
                        };
                    } else {
                        $options[CURLOPT_POSTFIELDS] = (string)$body;
                    }
                }
        }

        $options[CURLOPT_SSL_VERIFYPEER] = false;

        curl_setopt_array($curl, $options);

        return $options;
    }

    /**
     * @param  RequestInterface  $request
     * @return int
     */
    private function getProtocolVersion(RequestInterface $request): int
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

    /**
     * @param  RequestInterface  $request
     * @param  int  $errno
     * @param $curl
     * @return void
     * @throws CurlSSLException
     * @throws CurlCallbackException
     * @throws RequestException
     */
    protected function parseError(RequestInterface $request, int $errno, $curl): void
    {

        switch ($errno) {
            case CURLE_OK:
                break;
            case CURLE_COULDNT_RESOLVE_PROXY:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_COULDNT_CONNECT:
            case CURLE_OPERATION_TIMEOUTED:
            case CURLE_SSL_CONNECT_ERROR:
                throw new CurlSSLException($request, curl_error($curl), $errno);
            case CURLE_ABORTED_BY_CALLBACK:
                throw new CurlCallbackException($request, curl_error($curl), $errno);
            default:
                throw new RequestException($request, curl_error($curl), $errno);
        }
    }

    /**
     * @param  CurlHandle  $curl
     * @return void
     */
    protected function releaseCurlHandler(CurlHandle $curl): void
    {

        curl_setopt($curl, CURLOPT_HEADERFUNCTION, null);
        curl_setopt($curl, CURLOPT_READFUNCTION, null);
        curl_setopt($curl, CURLOPT_WRITEFUNCTION, null);
        curl_setopt($curl, CURLOPT_PROGRESSFUNCTION, null);
        curl_reset($curl);
    }
}