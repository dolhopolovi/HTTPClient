<?php

namespace Merce\RestClient\HttpPlug\src\DTO\Builder\Request;

use Nyholm\Psr7\Uri;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\Collection\HeaderCollection;

class RequestDTO {

    public ?Uri $uri = null;
    public ?EHttpMethod $httpMethod = null;
    public HeaderCollection $headerCollection;
    public string $body = '';

    public function __construct() {
        $this->headerCollection = new HeaderCollection();
    }
}