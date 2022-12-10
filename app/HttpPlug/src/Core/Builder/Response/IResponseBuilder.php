<?php

namespace Merce\RestClient\HttpPlug\src\Core\Builder\Response;

use Psr\Http\Message\ResponseInterface;

interface IResponseBuilder
{
    public function parseHeaderLine(string $headerLine): IResponseBuilder;
    public function setBody(string $input): self;
    public function getResponse(): ResponseInterface;
}