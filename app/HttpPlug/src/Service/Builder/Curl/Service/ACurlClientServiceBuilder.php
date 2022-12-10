<?php

namespace Merce\RestClient\HttpPlug\src\Service\Builder\Curl\Service;

use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Core\IClientService;

abstract class ACurlClientServiceBuilder
{
    protected readonly string $subClassInterface;

    public function __construct(
        protected readonly string $stringCurlClientService
    ) {
        $this->subClassInterface = 'IClientService';
    }

    public abstract function build(): IClientService;
}