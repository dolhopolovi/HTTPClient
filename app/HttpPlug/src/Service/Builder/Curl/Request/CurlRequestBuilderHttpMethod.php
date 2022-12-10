<?php

namespace Merce\RestClient\HttpPlug\src\Service\Builder\Curl\Request;

class CurlRequestBuilderHttpMethod
{
    private array $option = [];

    public function setCURLOPTNOBODY(bool $CURLOPT_NOBODY): self
    {
        $this->option['CURLOPT_NOBODY'] = $CURLOPT_NOBODY;
        return $this;
    }

    public function setCURLOPTHTTPGET(bool $CURLOPT_HTTPGET): self
    {
        $this->option['CURLOPT_HTTPGET'] = $CURLOPT_HTTPGET;
        return $this;
    }

    public function setCURLOPTPOSTFIELDS(string $CURLOPT_POSTFIELDS): self
    {
        $this->option['CURLOPT_POSTFIELDS'] = $CURLOPT_POSTFIELDS;
        return $this;
    }

    public function get(): array {
        return $this->option;
    }
}