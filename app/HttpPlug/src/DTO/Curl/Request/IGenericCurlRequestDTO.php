<?php

namespace Merce\RestClient\HttpPlug\src\DTO\Curl\Request;

use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl\GenericCurlRequestDTOHttpMethod;

interface IGenericCurlRequestDTO
{
    public function setCURLOPTCUSTOMREQUEST(string $CURLOPT_CUSTOMREQUEST): self;
    public function setCURLOPTURL(string $CURLOPT_URL): self;
    public function setCURLOPTHTTPHEADER(array $CURLOPT_HTTPHEADER): self;
    public function setCURLOPTHTTPVERSION(string $CURLOPT_HTTP_VERSION): self;
    public function setCURLOPTUSERPWD(string $CURLOPT_USERPWD): self;
    public function setGenericCurlRequestDTOHttpMethod(GenericCurlRequestDTOHttpMethod $genericCurlRequestDTOHttpMethod): self;
    public function setCURLOPTSSLVERIFYPEER(bool $CURLOPT_SSL_VERIFYPEER = false): self;
    public function get(): array;

}