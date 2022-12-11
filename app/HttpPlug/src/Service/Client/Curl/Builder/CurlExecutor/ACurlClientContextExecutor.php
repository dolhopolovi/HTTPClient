<?php

namespace Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\CurlExecutor;

use Psr\Http\Message\ResponseInterface;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\ICurlRequestPack;

abstract class ACurlClientContextExecutor
{

    public function __construct(
        private ICurlRequestPack $curlGenericRequestBuilder
    ) {
    }

    public abstract function execute(): ResponseInterface;
    protected abstract function parseError(): void;

    public abstract function __destruct();
}