<?php

declare(strict_types=1);

namespace Wonde\Entities\Collections;

abstract class Collection implements \Iterator
{
    private int $pointer = 0;
    private array $items;

    public function __construct(mixed ...$item)
    {
        $this->items = $item;
    }

    public function current(): mixed
    {
        return $this->items[$this->pointer];
    }

    public function next(): void
    {
        $this->pointer++;
    }

    public function key(): mixed
    {
        return $this->current()->id ?? $this->pointer;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->pointer]);
    }

    public function rewind(): void
    {
        $this->pointer = 0;
    }
}
