<?php
declare(strict_types=1);

namespace App\Application\Sanctuary;

use App\Domain\Pokemon\Sanctuary\SanctuaryRepository;
use App\Domain\Pokemon\Wild\Pokemon;

final class SanctuaryReleaser
{
    public function __construct(private readonly SanctuaryRepository $sanctuaryRepository){}

    public function __invoke(Pokemon $pokemon): void
    {
        $this->sanctuaryRepository->release($pokemon);
    }

    public function release(Pokemon $pokemon): void
    {
        $this($pokemon);
    }
}