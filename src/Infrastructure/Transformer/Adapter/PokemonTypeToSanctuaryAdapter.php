<?php
declare(strict_types=1);

namespace App\Infrastructure\Transformer\Adapter;

use App\Domain\Pokemon\Wild\Pokemon;

final class PokemonTypeToSanctuaryAdapter
{
    public function __invoke(Pokemon $pokemon): array
    {
        $types = [];

        foreach ($pokemon->types() as $type) {
            $types[] = [
                'code' => $pokemon->id(),
                'date_of_capture' => $pokemon->dateOfCapture(),
                'name' => $type->name(),
                'url' => $type->url()
            ];
        }

        return $types;
    }

    public function adapt(Pokemon $pokemon): array
    {
        return $this($pokemon);
    }
}