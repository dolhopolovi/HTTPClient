<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\HttpPlug\Builder\Response\DTO\Collection;

use PHPUnit\Framework\TestCase;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\HeaderDTO;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\Collection\HeaderCollection;

class HeaderCollectionTest extends TestCase
{

    public function testIsEmpty()
    {

        $headerCollection = new HeaderCollection();
        $headerCollection->append(new HeaderDTO());

        if ($headerCollection->isEmpty()) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}