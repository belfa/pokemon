<?php

declare(strict_types=1);

namespace App\Domain\Pokemon\Wild;

interface PokemonRepository
{
    public function catch(int $id);
}