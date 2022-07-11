<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Wild;

use JetBrains\PhpStorm\ArrayShape;

final class HeldItem
{
    private string $name;
    private string $url;
    private HeldItemDetailCollection $details;

    private function __construct(
        string             $name,
        string             $url,
        HeldItemDetailCollection $details
    )
    {
        $this->name = $name;
        $this->url = $url;
        $this->details = $details;
    }

    public static function attach(
        string             $name,
        string             $url,
        HeldItemDetailCollection $detail): self
    {
        return new self($name, $url, $detail);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function details(): HeldItemDetailCollection
    {
        return $this->details;
    }

    #[ArrayShape(
        [
            'name' => "string",
            'url' => "string",
            'details' => "array"
        ])]
    public function toArray(): array
    {
        return [
            'name' => $this->name(),
            'url' => $this->url(),
            'details' => $this->details()->toArray()
        ];
    }
}