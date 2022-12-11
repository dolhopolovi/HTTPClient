<?php

namespace Merce\RestClient\HttpPlug\src\DTO\Curl\Request;

interface IGenericCurlRequestDTOHttpMethod
{
    public function setCURLOPTNOBODY(bool $CURLOPT_NOBODY): self;
    public function setCURLOPTHTTPGET(bool $CURLOPT_HTTPGET): self;
    public function setCURLOPTPOSTFIELDS(string $CURLOPT_POSTFIELDS): self;
    public function get(): array;

}