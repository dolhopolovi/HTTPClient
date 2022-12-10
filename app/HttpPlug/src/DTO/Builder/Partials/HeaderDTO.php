<?php

namespace Merce\RestClient\HttpPlug\src\DTO\Builder\Partials;

class HeaderDTO {

    public function __construct(
        public ?string $headerHead = null,
        public ?string $headerTail = null) {
    }
}