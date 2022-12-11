<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Core\Client;

use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Factory\IFactoryCurlBuilder;

abstract class AHttpClient
{

    public function __construct(
        protected IFactoryCurlBuilder $curlHandler,
    ) {
    }
}