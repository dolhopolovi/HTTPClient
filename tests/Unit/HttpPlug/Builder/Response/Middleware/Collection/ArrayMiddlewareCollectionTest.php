<?php

namespace Merce\RestClient\Test\Unit\HttpPlug\Builder\Response\Middleware\Collection;

use ReflectionClass;
use PHPUnit\Framework\TestCase;
use Merce\RestClient\HttpPlug\src\DTO\Middleware\Collection\Impl\ArrayMiddlewareCollection;

class ArrayMiddlewareCollectionTest extends TestCase
{
    public function testGetForwardIterator(): void {
        $collection = new ArrayMiddlewareCollection();
        $reflection = new ReflectionClass($collection);
        $prop = $reflection->getProperty('middleWareCollection');
        $prop->setValue($collection, [1, 2, 3, 4]);

        foreach($collection->getForwardIterator() as $item) {

            if($item === 1) {
                $this->assertTrue(true);
                return;
            }
            $this->fail();
        }
    }

    public function testGetReverseIterator() {
        $collection = new ArrayMiddlewareCollection();
        $reflection = new ReflectionClass($collection);
        $prop = $reflection->getProperty('middleWareCollection');
        $prop->setValue($collection, ['a', 'b', 'c']);

        foreach($collection->getReverseIterator() as $item) {

            if($item === 'c') {
                $this->assertTrue(true);
                return;
            }
            $this->fail();
        }
    }
}