<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Wild;

use JetBrains\PhpStorm\ArrayShape;

final class Type
{
    private string $name;

    private string $url;

    private function __construct(
        string  $name,
        string  $url
    )
    {
        $this->name = $name;
        $this->url = $url;
    }

    public static function classify(
        string  $name,
        string  $url
    ): self
    {
        return new self($name, $url);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->url;
    }

    #[ArrayShape(['name' => "string", 'url' => "string"])]
    public function toArray(): array
    {
        return [
            'name' => $this->name(),
            'url' => $this->url()
        ];
    }
}