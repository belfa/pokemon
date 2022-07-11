<?php

namespace App\Tests\Application\Pokemon\Wild;

use App\Application\Pokemon\Wild\PokemonCatcher;
use App\Domain\Pokemon\Pokedex\PokedexRepository;
use App\Domain\Pokemon\Wild\CatchPokemonFailedException;
use App\Domain\Pokemon\Wild\PokemonRepository;
use App\Tests\Mother\PokemonMother;
use PHPUnit\Framework\TestCase;

class PokemonCatcherUnitTest extends TestCase
{
    public function testCatchPokemon(): void
    {
        $pokemon = PokemonMother::bulbasaur();
        $repository = $this->createMock(PokemonRepository::class);
        $repository->method('catch')->willReturn($pokemon);
        $catcher = new PokemonCatcher($repository);

        $pokemonFound = $catcher($pokemon->id());
        
        self::assertEquals($pokemon, $pokemonFound);
    }

    public function testNotCatchPokemon(): void
    {
        $pokemon = null;
        $pokemonId = 1;
        $repository = $this->createMock(PokemonRepository::class);
        $repository->method('catch')->willReturn($pokemon);
        $catcher = new PokemonCatcher($repository);

        $this->expectException(CatchPokemonFailedException::class);
        
        $catcher($pokemonId);
    }
}
