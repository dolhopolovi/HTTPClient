<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Service\Client\Curl\Factory;

use Merce\RestClient\HttpPlug\src\DTO\Curl\Request\IGenericCurlRequestDTO;
use Merce\RestClient\HttpPlug\src\Service\Client\Curl\Builder\ICurlBuilder;

interface IFactoryCurlBuilder
{

    public function init(IGenericCurlRequestDTO $genericCurlRequestDTO): ICurlBuilder;
}