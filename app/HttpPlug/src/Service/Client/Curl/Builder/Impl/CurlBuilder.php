<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Impl;

use Nyholm\Psr7\Stream;
use Merce\RestClient\HttpPlug\src\Support\FileSystem;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\ICurlRequestPack;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl\CurlRequestPack;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\IGenericCurlRequestDTO;
use Merce\RestClient\HttpPlug\src\Core\Builder\Request\Impl\RequestBuilder;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\ICurlBuilder;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl\GenericCurlRequestDTO;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl\GenericCurlExtraParamPack;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl\GenericCurlRequestDTOHttpMethod;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Partials\Logger\FileLoggerService;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Exception\InvalidCurlRequestConstruction;

class CurlBuilder implements ICurlBuilder
{

    use FileSystem;

    public function __construct(private readonly IGenericCurlRequestDTO $genericCurlRequestDTO = new GenericCurlRequestDTO())
    {

    }

    public function setGenericCurlExtraParamPack(): ICurlBuilder
    {

        $filePath = $this->getLibRoot() . "/config/http-plug.conf.json";

        if (file_exists($filePath)) {
            $config = fopen($filePath, "r");

            $data = '';
            try {
                $data = fread($config, filesize($filePath));
            }
            finally {
                fclose($config);
            }

            $data = json_decode($data);
            $requestPack = GenericCurlExtraParamPack::recreateFromJson($data);

            $this->genericCurlRequestDTO->setGenericCurlExtraParamPack($requestPack);
        }
        return $this;
    }

    public function setCURLOPTCUSTOMREQUEST(string $CURLOPT_CUSTOMREQUEST): ICurlBuilder
    {

        $this->genericCurlRequestDTO->setCURLOPTCUSTOMREQUEST($CURLOPT_CUSTOMREQUEST);
        return $this;
    }

    public function setCURLOPTURL(string $CURLOPT_URL): ICurlBuilder
    {

        $this->genericCurlRequestDTO->setCURLOPTURL($CURLOPT_URL);
        return $this;
    }

    public function setCURLOPTHTTPHEADER(array $CURLOPT_HTTPHEADER): ICurlBuilder
    {

        $this->genericCurlRequestDTO->setCURLOPTHTTPHEADER($CURLOPT_HTTPHEADER);
        return $this;
    }

    public function setCURLOPTHTTPVERSION(string $CURLOPT_HTTP_VERSION): ICurlBuilder
    {

        if (0 !== $version = $this->getProtocolVersion($CURLOPT_HTTP_VERSION)) {
            $this->genericCurlRequestDTO->setCURLOPTHTTPVERSION($version);
        }
        return $this;
    }

    public function setCURLOPTUSERPWD(string $CURLOPT_USERPWD): ICurlBuilder
    {

        $this->genericCurlRequestDTO->setCURLOPTUSERPWD($CURLOPT_USERPWD);
        return $this;
    }

    public function setHttpMethod(string $httpMethod, ?Stream $body = null): ICurlBuilder
    {

        $genericCurlRequestDTOHttpMethod = new GenericCurlRequestDTOHttpMethod();

        switch (EHttpMethod::from(strtoupper($httpMethod))) {
            case EHttpMethod::HEAD:
                $genericCurlRequestDTOHttpMethod->setCURLOPTNOBODY(true);
                break;

            case EHttpMethod::GET:
                $genericCurlRequestDTOHttpMethod->setCURLOPTHTTPGET(true);
                break;

            case EHttpMethod::POST:
            case EHttpMethod::PUT:
            case EHttpMethod::DELETE:
            case EHttpMethod::PATCH:
            case EHttpMethod::OPTIONS:
                if ($body !== null) {
                    $bodySize = $body->getSize();
                    if (0 !== $bodySize) {
                        $genericCurlRequestDTOHttpMethod->setCURLOPTPOSTFIELDS((string)$body);
                    }
                }
        }

        $this->genericCurlRequestDTO->setGenericCurlRequestDTOHttpMethod($genericCurlRequestDTOHttpMethod);

        return $this;
    }

    public function setCURLOPTSTDERR(FileLoggerService $loggerService = new FileLoggerService()): ICurlBuilder {
        $this->genericCurlRequestDTO->setCURLOPTSTDERR($loggerService->getResource());
        return $this;
    }

    public function setCURLOPTSSLVERIFYPEER(bool $CURLOPT_SSL_VERIFYPEER = false): ICurlBuilder
    {

        $this->genericCurlRequestDTO->setCURLOPTSSLVERIFYPEER($CURLOPT_SSL_VERIFYPEER);
        return $this;
    }

    public function buildRequest(): ICurlRequestPack
    {

        $this->curlOptCheckFlagList();

        $option = $this->genericCurlRequestDTO->get();

        $args = [
            'option' => $option,
            'request' => (new RequestBuilder())->setUri($option[CURLOPT_URL])->setMethod(EHttpMethod::from($option[CURLOPT_CUSTOMREQUEST]))->getRequest()
        ];

        //read only object

        return new CurlRequestPack(...$args);
    }

    private function curlOptCheckFlagList(): void {
        $mandatoryFlagList = [
            CURLOPT_CUSTOMREQUEST => 0,
            CURLOPT_URL => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_STDERR => 0,
            CURLOPT_VERBOSE => 0,
            CURLOPT_FAILONERROR => 0,
            CURLOPT_RETURNTRANSFER => 0,
            CURLOPT_HEADER => 0,

        ];

        if(array_diff_key($mandatoryFlagList, $this->genericCurlRequestDTO->get())) {
            throw new InvalidCurlRequestConstruction('Error: mandatory flags were not provided');
        }
    }

    public function buildExecutionContext(): \Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Partials\Executor\Impl\CurlClientContextExecutor
    {

        $data = $this->buildRequest();

        return new \Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Partials\Executor\Impl\CurlClientContextExecutor($data);
    }

    private function getProtocolVersion(string $CURLOPT_HTTP_VERSION): int
    {

        return match ($CURLOPT_HTTP_VERSION) {
            '1.0'   => CURL_HTTP_VERSION_1_0,
            '1.1'   => CURL_HTTP_VERSION_1_1,
            '2.0'   => CURL_HTTP_VERSION_2_0,
            default => 0,
        };
    }
}

