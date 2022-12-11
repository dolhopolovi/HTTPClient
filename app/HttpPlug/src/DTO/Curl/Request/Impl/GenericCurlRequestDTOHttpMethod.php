<?php

namespace Merce\RestClient\HttpPlug\src\Service\Builder\Curl\Request;

class CurlRequestBuilderHttpMethod
{
    private array $option = [];

    public function setCURLOPTNOBODY(bool $CURLOPT_NOBODY): IGenericCurlRequestDTOHttpMethod
    {
        $this->option[CURLOPT_NOBODY] = $CURLOPT_NOBODY;
        return $this;
    }

    public function setCURLOPTHTTPGET(bool $CURLOPT_HTTPGET): IGenericCurlRequestDTOHttpMethod
    {
        $this->option[CURLOPT_HTTPGET] = $CURLOPT_HTTPGET;
        return $this;
    }

    public function setCURLOPTPOSTFIELDS(string $CURLOPT_POSTFIELDS): IGenericCurlRequestDTOHttpMethod
    {
        $this->option[CURLOPT_POSTFIELDS] = $CURLOPT_POSTFIELDS;
        return $this;
    }

    public function get(): array {
        return $this->option;
    }
}