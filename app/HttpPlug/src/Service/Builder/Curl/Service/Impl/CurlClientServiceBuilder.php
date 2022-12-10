<?php

namespace Merce\RestClient\HttpPlug\src\Service\Builder\Curl\Service\Impl;

use Merce\RestClient\HttpPlug\src\Exception\Impl\NotImplementedException;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Core\IClientService;
use Merce\RestClient\HttpPlug\src\Service\Builder\Curl\Service\ACurlClientServiceBuilder;

class CurlClientServiceBuilder extends ACurlClientServiceBuilder
{
    public function build(): IClientService
    {
        if(class_exists($this->stringCurlClientService) && is_subclass_of($this->stringCurlClientService, $this->subClassInterface)) {
            return new $this->stringCurlClientService();
        }

        throw new NotImplementedException("Error: class $this->stringCurlClientService does not exist/does not implement ");

    }
}