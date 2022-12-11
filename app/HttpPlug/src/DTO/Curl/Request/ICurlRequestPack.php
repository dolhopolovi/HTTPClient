<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\DTO\Curl\Request;

interface ICurlRequestPack
{

    public function getData();

    public function getPSRRequest();
}