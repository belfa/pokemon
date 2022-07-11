<?php
declare(strict_types=1);

namespace App\Infrastructure\Port\Controller\Hunter;

use App\Application\Pokedex\PokemonRecord;
use App\Application\Pokemon\Wild\PokemonCatcher;
use App\Application\Sanctuary\SanctuaryReleaser;
use App\Domain\Pokemon\Pokedex\PokedexRepository;
use App\Domain\Pokemon\Sanctuary\SanctuaryRepository;
use App\Domain\Pokemon\Wild\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HuntingTimePostController extends AbstractController
{
    private PokemonCatcher $catcher;
    private PokemonRecord $recorder;
    private SanctuaryReleaser $releaser;

    public function __construct(
        PokemonRepository $pokemonRepository,
        PokedexRepository $pokedexRepository,
        SanctuaryRepository $sanctuaryRepository
    )
    {
        $this->catcher = new PokemonCatcher($pokemonRepository);
        $this->recorder = new PokemonRecord($pokedexRepository);
        $this->releaser = new SanctuaryReleaser($sanctuaryRepository);
    }

    /** @Route("/api/hunter/{numberOfCaptures}", methods={"GET"}) */
    public function __invoke(int $numberOfCaptures): Response
    {
        for ($i = 1; $i <= $numberOfCaptures; $i++) {
            $pokemonId = rand(1, 905);
            $pokemon = $this->catcher->catch($pokemonId);
            $this->recorder->record($pokemon);
            $this->releaser->release($pokemon);
        }

        return new Response("", Response::HTTP_OK);
    }
}