<?php

namespace Merce\RestClient\HttpPlug\src\DTO\Builder\Response;

use Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\Collection\HeaderCollection;

class ResponseDTO {

    public ?ResponseStatusInfoDTO $responseStatusInfoContainer = null;
    public HeaderCollection $headerCollection;
    public string $body = '';

    public function __construct() {
        $this->headerCollection = new HeaderCollection();
    }
}