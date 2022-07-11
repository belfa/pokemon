<?php

declare(strict_types=1);

namespace App\Domain\Pokemon\Wild;

use JetBrains\PhpStorm\ArrayShape;

final class Pokemon
{
    private int $id;

    private string $name;

    private float $dateOfCapture;

    private TypeCollection $types;

    private SpriteCollection $sprites;

    private HeldItemCollection $heldItem;

    private function __construct(
        int $id,
        string $name,
        float $dateOfCapture
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->dateOfCapture = $dateOfCapture;
        $this->types = new TypeCollection();
        $this->sprites = new SpriteCollection();
        $this->heldItem = new HeldItemCollection();
    }

    public static function catchUp(
        int $id,
        string $name,
        float $dateOfCapture
    ): self
    {
        return new self($id, $name, $dateOfCapture);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function dateOfCapture(): float
    {
        return $this->dateOfCapture;
    }

    public function addType(Type $type): self
    {
        $this->types->add($type);
        return $this;
    }

    public function types(): TypeCollection
    {
        return $this->types;
    }

    public function addSprite(Sprite $sprite): self
    {
        $this->sprites->add($sprite);
        return $this;
    }

    public function sprites(): SpriteCollection
    {
        return $this->sprites;
    }

    public function addHeldItem(HeldItem $heldItem): self
    {
        $this->heldItem->add($heldItem);
        return $this;
    }

    public function heldItem(): HeldItemCollection
    {
        return $this->heldItem;
    }

    #[ArrayShape(['id' => "int",
        'name' => "string",
        'date_of_capture' => "int",
        'types' => "array",
        'sprites' => "array",
        'heldItems' => "array"
    ])]
    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'date_of_capture' => $this->dateOfCapture,
            'types' => $this->types()->toArray(),
            'sprites' => $this->sprites()->toArray(),
            'heldItems' => $this->heldItem()->toArray()
        ];
    }
}