<?php
declare(strict_types=1);

namespace App\Tests\Mother;

use App\Domain\Pokemon\Wild\Pokemon;

final class PokemonMother
{
    public static function bulbasaur(): Pokemon
    {
        return Pokemon::catchUp(
            1,
            'bulbasaur',
            1657218907.3078
        );
    }
}