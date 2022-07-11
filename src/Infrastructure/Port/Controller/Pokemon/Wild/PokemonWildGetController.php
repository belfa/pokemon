<?php
declare(strict_types=1);

namespace App\Infrastructure\Port\Controller\Pokemon\Wild;

use App\Application\Pokemon\Wild\PokemonCatcher;
use App\Domain\Pokemon\Wild\CatchPokemonFailedException;
use App\Domain\Pokemon\Wild\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PokemonWildGetController extends AbstractController
{
    private PokemonCatcher $catcher;

    public function __construct(PokemonRepository $repository)
    {
        $this->catcher = new PokemonCatcher($repository);
    }

    /** @Route("/api/pokemon/wild/{id}") */
    public function __invoke(int $id): Response
    {
        try {
            $pokemon = $this->catcher->catch($id);
            return new JsonResponse($pokemon->toArray(), Response::HTTP_OK);
        } catch (CatchPokemonFailedException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}