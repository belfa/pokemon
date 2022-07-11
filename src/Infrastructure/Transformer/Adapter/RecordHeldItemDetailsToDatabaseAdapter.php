<?php
declare(strict_types=1);

namespace App\Infrastructure\Transformer\Adapter;

use App\Domain\Pokemon\Wild\HeldItemDetailCollection;
use Symfony\Component\Uid\Uuid;

final class RecordHeldItemDetailsToDatabaseAdapter
{
    public function __invoke(string $heldItemId, HeldItemDetailCollection $detailCollection): array
    {
        $details = [];
        foreach ($detailCollection as $detail) {
            $details[] = [
                'id' => Uuid::v4()->toRfc4122(),
                'pokedex_held_item_id' => $heldItemId,
                'rarity' => $detail->rarity(),
                'name' => $detail->name(),
                'url' => $detail->url()
            ];
        }
        return $details;
    }

    public function adapt(string $heldItemId, HeldItemDetailCollection $detailCollection): array
    {
        return $this($heldItemId, $detailCollection);
    }
}