<?php

namespace Merce\RestClient\HttpPlug\src\DTO\Middleware\Collection\Impl;

use Merce\RestClient\HttpPlug\src\Core\Middleware\IMiddleware;
use Merce\RestClient\HttpPlug\src\DTO\Middleware\Collection\IMiddlewareCollection;

class ArrayMiddlewareCollection implements IMiddlewareCollection
{

    private array $middleWareCollection;

    public function __construct(IMiddleware ...$middleWareCollection) {
        $this->middleWareCollection = $middleWareCollection;
    }

    public function push(IMiddleware $middleware, int $index = -1): void {
        $this->middleWareCollection[] = $middleware;
    }

    public function pop(int $index = -1): ?IMiddleware {
        return array_shift($this->middleWareCollection);
    }

    public function getForwardIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->middleWareCollection);
    }

    public function getReverseIterator(): \ArrayIterator
    {
        return new \ArrayIterator(array_reverse($this->middleWareCollection));
    }
}
