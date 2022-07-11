<?php

declare(strict_types=1);

namespace App\Infrastructure\Transformer\Adapter;

use App\Domain\Pokemon\Wild\Pokemon;

final class PokemonSpriteToSanctuaryAdapter
{
    public function __invoke(Pokemon $pokemon): array
    {
        $sprites = [];

        foreach ($pokemon->sprites() as $sprite) {
            $sprites[] = [
                'code' => $pokemon->id(),
                'date_of_capture' => $pokemon->dateOfCapture(),
                'url' => $sprite->url()
            ];
        }
        
        return $sprites;
    }

    public function adapt(Pokemon $pokemon): array
    {
        return $this($pokemon);
    }
}