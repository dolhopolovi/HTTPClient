<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\Core\Builder\Request;

use Psr\Http\Message\RequestInterface;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;

interface IRequestBuilder
{

    public function setMethod(EHttpMethod $method): self;

    public function setUri(string $uri): self;

    public function setHeaders(array $headers): self;

    public function setBody(string $body): self;

    public function getRequest(): RequestInterface;
}