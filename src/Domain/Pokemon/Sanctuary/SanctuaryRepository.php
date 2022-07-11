<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Sanctuary;

use App\Domain\Pokemon\Wild\Pokemon;

interface SanctuaryRepository
{
    public function release(Pokemon $pokemon): void;
}