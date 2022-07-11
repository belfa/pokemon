<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Pokedex;

use App\Domain\Pokemon\Wild\Pokemon;

final class Record
{
    private string $id;

    private Pokemon $pokemon;

    private function __construct(
        string $id,
        Pokemon $pokemon
    )
    {
        $this->id = $id;
        $this->pokemon = $pokemon;
    }

    public static function write(string $id, Pokemon $pokemon): self
    {
        return new self($id, $pokemon);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function pokemon(): Pokemon
    {
        return $this->pokemon;
    }
}