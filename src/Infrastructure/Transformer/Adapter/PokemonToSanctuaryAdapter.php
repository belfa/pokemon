<?php

declare(strict_types=1);

namespace App\Infrastructure\Transformer\Adapter;

use App\Domain\Pokemon\Wild\Pokemon;
use JetBrains\PhpStorm\ArrayShape;

final class PokemonToSanctuaryAdapter
{
    private PokemonSpriteToSanctuaryAdapter $spriteAdapter;
    private PokemonTypeToSanctuaryAdapter $typeAdapter;
    private PokemonHeldItemToSanctuaryAdapter $heldItemAdapter;

    public function __construct(
        PokemonSpriteToSanctuaryAdapter   $spriteAdapter,
        PokemonTypeToSanctuaryAdapter     $typeAdapter,
        PokemonHeldItemToSanctuaryAdapter $heldItemAdapter
    )
    {
        $this->spriteAdapter = $spriteAdapter;
        $this->typeAdapter = $typeAdapter;
        $this->heldItemAdapter = $heldItemAdapter;
    }

    #[ArrayShape(
        [
            'code' => "int",
            'date_of_capture' => "int",
            'name' => "string",
            'sprites' => "array",
            'types' => "array",
            'held_items' => "array"
        ]
    )]
    public function __invoke(Pokemon $pokemon): array
    {
        return [
            'code' => $pokemon->id(),
            'date_of_capture' => $pokemon->dateOfCapture(),
            'name' => $pokemon->name(),
            'sprites' => $this->spriteAdapter->adapt($pokemon),
            'types' => $this->typeAdapter->adapt($pokemon),
            'held_items' => $this->heldItemAdapter->adapt($pokemon)
        ];
    }

    #[ArrayShape(
        [
            'code' => "int",
            'date_of_capture' => "int",
            'name' => "string",
            'sprites' => "array",
            'types' => "array",
            'held_items' => "array"
        ]
    )]
    public function adapt(Pokemon $pokemon): array
    {
        return $this($pokemon);
    }
}