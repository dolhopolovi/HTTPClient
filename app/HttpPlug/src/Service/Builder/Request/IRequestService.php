<?php

namespace Merce\RestClient\HttpPlug\src\Service\Builder\Request;

use Nyholm\Psr7\Uri;
use Merce\RestClient\HttpPlug\src\Support\EHttpMethod;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\Collection\HeaderCollection;

interface IRequestService {

    public function setHttpMethod(EHttpMethod $httpMethod): self;
    public function setUri(string $uri): self;
    public function setHeaders(array $headers): self;
    public function setBody(string $body): self;

    public function getUri(): Uri;
    public function getHttpMethod(): string;
    public function getHeaderCollection(): HeaderCollection;
    public function getBody(): string;
}