<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Client;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;

abstract class AHttpClient
{

    public function __construct(
        protected ResponseFactoryInterface $responseFactory = new Psr17Factory()
    ) {
    }
}