<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Factory\Impl;

use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\IGenericCurlRequestDTO;
use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\Impl\GenericCurlRequestDTO;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\CurlBuilder\ICurlBuilder;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Factory\IFactoryCurlBuilder;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\CurlBuilder\Impl\CurlBuilder;

class FactoryCurlBuilderFactory implements IFactoryCurlBuilder
{

    public function __construct() { }

    public function init(IGenericCurlRequestDTO $genericCurlRequestDTO = new GenericCurlRequestDTO()): ICurlBuilder
    {

        return new CurlBuilder($genericCurlRequestDTO);
    }
}