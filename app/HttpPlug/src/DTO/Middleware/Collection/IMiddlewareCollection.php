<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\DTO\Middleware\Collection;

use ArrayIterator;
use Merce\RestClient\HttpPlug\src\Core\Middleware\IMiddleware;

interface IMiddlewareCollection
{

    public function push(IMiddleware $middleware, int $index = -1): void;

    public function pop(int $index = -1): ?IMiddleware;

    public function getForwardIterator(): ArrayIterator;

    public function getReverseIterator(): ArrayIterator;
}
