<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Collections;

use Paddle\SDK\Entities\Entity;

abstract class Collection implements \Iterator
{
    private int $pointer = 0;

    protected function __construct(
        protected array $items,
        protected Paginator|null $paginator = null,
    ) {
    }

    abstract public static function from(array $data, Paginator|null $paginator): self;

    public function current(): Entity
    {
        return $this->items[$this->pointer];
    }

    public function next(): void
    {
        ++$this->pointer;
    }

    public function key(): mixed
    {
        return $this->items[$this->pointer]?->id ?? $this->pointer;
    }

    public function valid(): bool
    {
        $loaded = isset($this->items[$this->pointer]);

        if ($loaded) {
            return true;
        }

        if ($this->paginator?->hasMore()) {
            $collection = $this->paginator->nextPage();

            $this->rewind();
            $this->items = $collection->items;
            $this->paginator = $collection->paginator;

            return true;
        }

        return false;
    }

    public function rewind(): void
    {
        $this->pointer = 0;
    }
}
