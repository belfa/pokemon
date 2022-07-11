<?php
declare(strict_types=1);

namespace App\Domain\Pokemon\Wild;

use DomainException;

final class CatchPokemonFailedException extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function with(int $id): self
    {
        return new self("Failed to capture wild pokemon with id: {$id}");
    }
}