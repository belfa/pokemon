<?php
declare(strict_types=1);

namespace App\Infrastructure\Transformer\Adapter;

use App\Domain\Pokemon\Wild\HeldItemDetailCollection;

final class PokemonHeldItemDetailsToSanctuaryAdapter
{
    public function __invoke(int                      $pokemonCode,
                             float                    $pokemonDateOfCapture,
                             string                   $itemName,
                             HeldItemDetailCollection $detailCollection): array
    {
        $details = [];
        foreach ($detailCollection as $detail) {
            $details[] = [
                'code' => $pokemonCode,
                'date_of_capture' => $pokemonDateOfCapture,
                'item_name' => $itemName,
                'rarity' => $detail->rarity(),
                'name' => $detail->name(),
                'url' => $detail->url()
            ];
        }
        return $details;
    }

    public function adapt(int                      $pokemonCode,
                          float                    $pokemonDateOfCapture,
                          string                   $itemName,
                          HeldItemDetailCollection $detailCollection): array
    {
        return $this($pokemonCode, $pokemonDateOfCapture, $itemName, $detailCollection);
    }
}