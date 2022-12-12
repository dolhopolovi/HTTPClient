<?php

declare(strict_types = 1);

namespace Merce\RestClient\Test\Unit\HttpPlug\Builder\Response\Middleware\Collection;

use ReflectionClass;
use ReflectionException;
use PHPUnit\Framework\TestCase;
use Merce\RestClient\HttpPlug\src\DTO\Middleware\Collection\IMiddlewareCollection;
use Merce\RestClient\HttpPlug\src\DTO\Middleware\Collection\Impl\ArrayMiddlewareCollection;

class ArrayMiddlewareCollectionTest extends TestCase
{

    private IMiddlewareCollection $collection;

    /**
     * @throws ReflectionException
     */
    public function testGetForwardIterator(): void
    {

        $reflection = new ReflectionClass($this->collection);
        $prop = $reflection->getProperty('middleWareCollection');
        $prop->setValue($this->collection, [1, 2, 3, 4]);

        foreach ($this->collection->getForwardIterator() as $item) {
            if ($item === 1) {
                $this->assertTrue(true);
                return;
            }
            $this->fail();
        }
    }

    /**
     * @throws ReflectionException
     */
    public function testGetReverseIterator()
    {

        $reflection = new ReflectionClass($this->collection);
        $prop = $reflection->getProperty('middleWareCollection');
        $prop->setValue($this->collection, ['a', 'b', 'c']);

        foreach ($this->collection->getReverseIterator() as $item) {
            if ($item === 'c') {
                $this->assertTrue(true);
                return;
            }
            $this->fail();
        }
    }

    public function setUp(): void
    {

        parent::setUp();

        $this->collection = new ArrayMiddlewareCollection();
    }
}