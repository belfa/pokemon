<?php
declare(strict_types=1);

namespace App\Infrastructure\Transformer\Adapter;

use App\Domain\Pokemon\Wild\Pokemon;

final class PokemonHeldItemToSanctuaryAdapter
{
    private PokemonHeldItemDetailsToSanctuaryAdapter $detailAdapter;

    public function __construct(PokemonHeldItemDetailsToSanctuaryAdapter $detailAdapter)
    {
        $this->detailAdapter = $detailAdapter;
    }

    public function __invoke(Pokemon $pokemon): array
    {
        $heldItems = [];
        foreach ($pokemon->heldItem() as $heldItem) {
            $heldItems[] = [
                'code' => $pokemon->id(),
                'date_of_capture' => $pokemon->dateOfCapture(),
                'item_name' => $heldItem->name(),
                'url' => $heldItem->url(),
                'details' => $this->detailAdapter->adapt(
                    $pokemon->id(),
                    $pokemon->dateOfCapture(),
                    $heldItem->name(),
                    $heldItem->details()
                )
            ];
        }
        return $heldItems;
    }

    public function adapt(Pokemon $pokemon): array
    {
        return $this($pokemon);
    }
}