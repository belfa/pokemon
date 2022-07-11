<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Wild;

use ArrayIterator as ArrayIteratorAlias;

final class HeldItemCollection extends ArrayIteratorAlias
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add(HeldItem $item): self
    {
        $this->append($item);
        return $this;
    }

    public function toArray(): array
    {
        $items = [];

        foreach ($this as $item) {
            $items[] = $item->toArray();
        }

        return $items;
    }
}