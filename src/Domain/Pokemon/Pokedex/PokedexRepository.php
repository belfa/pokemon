<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Pokedex;

interface PokedexRepository
{
    public function register(Record $record): void;
}