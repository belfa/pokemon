<?php

declare(strict_types=1);

namespace App\Application\Pokemon\Wild;

use App\Domain\Pokemon\Wild\CatchPokemonFailedException;
use App\Domain\Pokemon\Wild\Pokemon;
use App\Domain\Pokemon\Wild\PokemonRepository;

final class PokemonCatcher
{
    public function __construct(private readonly PokemonRepository $repository){}

    public function __invoke(int $id): Pokemon
    {
        $pokemon = $this->repository->catch($id);

        if (is_null($pokemon)) {
            throw CatchPokemonFailedException::with($id);
        }

        return $pokemon;
    }

    public function catch(int $id): Pokemon
    {
        return $this($id);
    }
}