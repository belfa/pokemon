<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Wild;

use JetBrains\PhpStorm\ArrayShape;

final class Sprite
{
    private string $url;

    private function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function draw(string $url): self
    {
        return new self($url);
    }

    public function url(): string
    {
        return $this->url;
    }

    #[ArrayShape(['url' => "string"])]
    public function toArray(): array
    {
        return ['url' => $this->url()];
    }
}