<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\DTO\Curl\Request;

use Psr\Http\Message\RequestInterface;

interface ICurlRequestPack
{

    public function getData(): array;

    public function getPSRRequest(): RequestInterface;
}