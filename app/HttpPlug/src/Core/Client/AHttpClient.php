<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Core\Client;

use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Core\IClientService;

abstract class AHttpClient
{

    public function __construct(
        protected IClientService $clientService,
    ) {
    }
}