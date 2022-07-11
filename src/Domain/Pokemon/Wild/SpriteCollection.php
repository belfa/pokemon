<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Wild;

use ArrayIterator;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

final class SpriteCollection extends ArrayIterator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add(Sprite $sprite): self
    {
        $this->append($sprite);
        return $this;
    }

    public function toArray(): array
    {
        $sprites = [];

        foreach ($this as $sprite) {
            $sprites[] = $sprite->toArray();
        }

        return $sprites;
    }
}