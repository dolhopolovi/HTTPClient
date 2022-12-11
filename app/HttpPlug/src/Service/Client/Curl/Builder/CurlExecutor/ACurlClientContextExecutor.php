<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\CurlExecutor;

use Psr\Http\Message\ResponseInterface;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\ICurlRequestPack;

abstract class ACurlClientContextExecutor
{

    public function __construct(
        protected readonly ICurlRequestPack $curlGenericRequestBuilder
    ) {
    }

    public abstract function execute(): ResponseInterface;

    public abstract function __destruct();

    protected abstract function parseError(): void;
}