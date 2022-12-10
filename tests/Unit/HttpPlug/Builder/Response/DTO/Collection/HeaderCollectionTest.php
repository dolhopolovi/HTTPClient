<?php

namespace Merce\RestClient\Test\Unit\HttpPlug\Builder\Response\DTO\Collection;

use PHPUnit\Framework\TestCase;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\HeaderDTO;

class HeaderCollectionTest extends TestCase
{
    public function testIsEmpty() {
        $headerCollection = new \Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\Collection\HeaderCollection();
        $headerCollection->append(new HeaderDTO());

        if($headerCollection->isEmpty()) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }
}