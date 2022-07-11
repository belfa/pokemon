<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Wild;

use ArrayIterator;

final class HeldItemDetailCollection extends ArrayIterator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add(HeldItemDetail $detail): self
    {
        $this->append($detail);
        return $this;
    }

    public function toArray(): array
    {
        $details = [];

        foreach ($this as $detail) {
            $details[] = $detail->toArray();
        }

        return $details;
    }
}