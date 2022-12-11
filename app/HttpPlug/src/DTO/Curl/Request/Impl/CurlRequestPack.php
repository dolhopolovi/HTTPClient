<?php

namespace Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl;

use Psr\Http\Message\RequestInterface;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\ICurlRequestPack;

class CurlRequestPack implements ICurlRequestPack {

    public function __construct(private readonly array $option, private readonly RequestInterface $request) { }

    public function getData(): array
    {
        return $this->option;
    }

    public function getPSRRequest(): RequestInterface
    {
        return clone $this->request;
    }
}