<?php

declare(strict_types = 1);

namespace Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\Collection;

use Iterator;
use Merce\RestClient\HttpPlug\src\DTO\Builder\Partials\HeaderDTO;

class HeaderCollection implements Iterator
{

    /* @var HeaderDTO[] $collection */
    private array $collection;

    public function __construct(HeaderDTO ...$collection)
    {

        $this->collection = $collection;
    }

    public function append(HeaderDTO $headerDTO): void
    {

        $this->collection[] = $headerDTO;
    }

    public function current(): HeaderDTO
    {

        return current($this->collection);
    }

    public function next(): void
    {

        next($this->collection);
    }

    public function key(): int
    {

        return key($this->collection);
    }

    public function valid(): bool
    {

        return current($this->collection) !== false;
    }

    public function rewind(): void
    {

        reset($this->collection);
    }

    public function isEmpty(): bool
    {

        return empty($this->collection);
    }
}