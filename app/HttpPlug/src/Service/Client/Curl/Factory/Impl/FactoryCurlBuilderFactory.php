<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Service\Client\Curl\Factory\Impl;

use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\IGenericCurlRequestDTO;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\ICurlBuilder;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl\GenericCurlRequestDTO;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Impl\CurlBuilder;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Factory\IFactoryCurlBuilder;

class FactoryCurlBuilderFactory implements IFactoryCurlBuilder
{

    public function __construct() { }

    public function init(IGenericCurlRequestDTO $genericCurlRequestDTO = new GenericCurlRequestDTO()): ICurlBuilder
    {

        return new CurlBuilder($genericCurlRequestDTO);
    }
}