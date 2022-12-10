<?php

namespace Merce\RestClient\HttpPlug\src\Service\Builder\Curl\Request;

use Psr\Http\Message\RequestInterface;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;
use Merce\RestClient\HttpPlug\src\Core\Builder\Request\Impl\RequestBuilder;
use Merce\RestClient\HttpPlug\src\Core\Builder\Response\Impl\ResponseBuilder;
use Merce\RestClient\HttpPlug\src\Service\Builder\Request\Impl\RequestService;

class CurlRequestBuilder
{
    private array $option = [];

    public function setCURLOPTHEADER(bool $CURLOPT_HEADER): self
    {
        $this->option['CURLOPT_HEADER'] = $CURLOPT_HEADER;
        return $this;
    }

    public function setCURLOPTRETURNTRANSFER(bool $CURLOPT_RETURNTRANSFER): self
    {
        $this->option['CURLOPT_RETURNTRANSFER'] = $CURLOPT_RETURNTRANSFER;
        return $this;
    }

    public function setCURLOPTFAILONERROR(bool $CURLOPT_FAILONERROR): self
    {
        $this->option['CURLOPT_FAILONERROR'] = $CURLOPT_FAILONERROR;
        return $this;
    }

    public function setCURLOPTCUSTOMREQUEST(string $CURLOPT_CUSTOMREQUEST): self
    {

        $this->option['CURLOPT_CUSTOMREQUEST'] = $CURLOPT_CUSTOMREQUEST;
        return $this;
    }

    public function setCURLOPTURL(string $CURLOPT_URL): self
    {

        $this->option['CURLOPT_URL'] = $CURLOPT_URL;
        return $this;
    }


    public function setCURLOPTHTTPHEADER(array $CURLOPT_HTTPHEADER): self
    {

        $this->option['CURLOPT_HTTPHEADER'] = $CURLOPT_HTTPHEADER;
        return $this;
    }

    public function setCURLOPTHTTPVERSION(string $CURLOPT_HTTP_VERSION): self
    {

        $this->option['CURLOPT_HTTP_VERSION'] = $CURLOPT_HTTP_VERSION;
        return $this;
    }

    public function setCURLOPTUSERPWD(string $CURLOPT_USERPWD): self
    {

        $this->option['CURLOPT_USERPWD'] = $CURLOPT_USERPWD;
        return $this;
    }

    public function setHttpMethod(CurlRequestBuilderHttpMethod $curlRequestBuilderHttpMethod): self {

        $this->option = array_merge($this->option, $curlRequestBuilderHttpMethod->get());
        return $this;
    }

    public function setCURLOPTSSLVERIFYPEER(bool $CURLOPT_SSL_VERIFYPEER = false): self {

        $this->option['CURLOPT_SSL_VERIFYPEER'] = $CURLOPT_SSL_VERIFYPEER;
        return $this;
    }

    public function restorePSRRequest(): RequestInterface {
        return (new RequestBuilder())
            ->setUri($this->option['CURLOPT_URL'])
            ->setMethod(EHttpMethod::from($this->option['setCURLOPTCUSTOMREQUEST']))
            ->getRequest();
    }

    public function get(): array {
        return $this->option;
    }
}