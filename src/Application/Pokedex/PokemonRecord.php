<?php
declare(strict_types=1);

namespace App\Application\Pokedex;

use App\Domain\Pokemon\Pokedex\PokedexRepository;
use App\Domain\Pokemon\Pokedex\Record;
use App\Domain\Pokemon\Wild\Pokemon;
use Symfony\Component\Uid\Uuid;

final class PokemonRecord
{
    public function __construct(private readonly PokedexRepository $repository){}

    public function __invoke(Pokemon $pokemon): void
    {
        $record = Record::write(
            Uuid::v4()->toRfc4122(),
            $pokemon
        );

        $this->repository->register($record);
    }

    public function record(Pokemon $pokemon): void
    {
        $this($pokemon);
    }
}