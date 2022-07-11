<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Wild;

use ArrayIterator;

final class TypeCollection extends ArrayIterator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add(Type $type): self
    {
        $this->append($type);
        return $this;
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this as $type) {
            $result[] = $type->toArray();
        }
        return $result;
    }
}