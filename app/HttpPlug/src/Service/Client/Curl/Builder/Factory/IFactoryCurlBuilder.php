<?php

namespace Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\Factory;

use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\IGenericCurlRequestDTO;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\CurlBuilder\ICurlBuilder;

interface IFactoryCurlBuilder
{
    public function init(IGenericCurlRequestDTO $genericCurlRequestDTO): ICurlBuilder;
}