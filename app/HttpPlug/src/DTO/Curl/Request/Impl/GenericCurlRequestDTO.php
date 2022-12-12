<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl;

use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\IGenericCurlRequestDTO;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\IGenericCurlExtraParamPack;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\IGenericCurlRequestDTOHttpMethod;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Partials\Logger\FileLoggerService;

class GenericCurlRequestDTO implements IGenericCurlRequestDTO
{

    private array $option = [];

    public function __construct()
    {
    }

    public function setCURLOPTCUSTOMREQUEST(string $CURLOPT_CUSTOMREQUEST): IGenericCurlRequestDTO
    {

        $this->option[CURLOPT_CUSTOMREQUEST] = $CURLOPT_CUSTOMREQUEST;
        return $this;
    }

    public function setCURLOPTURL(string $CURLOPT_URL): IGenericCurlRequestDTO
    {

        $this->option[CURLOPT_URL] = $CURLOPT_URL;
        return $this;
    }

    public function setCURLOPTHTTPHEADER(array $CURLOPT_HTTPHEADER): IGenericCurlRequestDTO
    {

        $this->option[CURLOPT_HTTPHEADER] = $CURLOPT_HTTPHEADER;
        return $this;
    }

    public function setCURLOPTHTTPVERSION(int $CURLOPT_HTTP_VERSION): IGenericCurlRequestDTO
    {

        $this->option[CURLOPT_HTTP_VERSION] = $CURLOPT_HTTP_VERSION;
        return $this;
    }

    public function setCURLOPTUSERPWD(string $CURLOPT_USERPWD): IGenericCurlRequestDTO
    {

        $this->option[CURLOPT_USERPWD] = $CURLOPT_USERPWD;
        return $this;
    }

    public function setGenericCurlRequestDTOHttpMethod(IGenericCurlRequestDTOHttpMethod $genericCurlRequestDTOHttpMethod): IGenericCurlRequestDTO
    {

        $this->option += $genericCurlRequestDTOHttpMethod->get();
        return $this;
    }

    public function setCURLOPTSSLVERIFYPEER(bool $CURLOPT_SSL_VERIFYPEER = false): IGenericCurlRequestDTO
    {

        $this->option[CURLOPT_SSL_VERIFYPEER] = $CURLOPT_SSL_VERIFYPEER;
        return $this;
    }

    public function get(): array
    {

        return $this->option;
    }

    public function setGenericCurlExtraParamPack(IGenericCurlExtraParamPack $genericCurlExtraParamPack): IGenericCurlRequestDTO
    {

        $this->option = array_replace($this->option, $genericCurlExtraParamPack->get());
        return $this;
    }
}