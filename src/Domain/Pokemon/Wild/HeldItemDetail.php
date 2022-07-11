<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Wild;

use JetBrains\PhpStorm\ArrayShape;

final class HeldItemDetail
{
    private int $rarity;
    private string $name;
    private string $url;

    private function __construct(
        int    $rarity,
        string $name,
        string $url
    )
    {
        $this->rarity = $rarity;
        $this->name = $name;
        $this->url = $url;
    }

    public static function with(
        int    $rarity,
        string $name,
        string $url
    ): self
    {
        return new self($rarity, $name, $url);
    }

    public function rarity(): int
    {
        return $this->rarity;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->url;
    }

    #[ArrayShape(['rarity' => "int", 'name' => "string", 'url' => "string"])]
    public function toArray(): array
    {
        return [
            'rarity' => $this->rarity(),
            'name' => $this->name(),
            'url' => $this->url()
        ];
    }
}