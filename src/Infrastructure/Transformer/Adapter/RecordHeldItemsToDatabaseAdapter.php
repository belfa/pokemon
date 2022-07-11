<?php
declare(strict_types=1);

namespace App\Infrastructure\Transformer\Adapter;

use App\Domain\Pokemon\Pokedex\Record;
use Symfony\Component\Uid\Uuid;

final class RecordHeldItemsToDatabaseAdapter
{
    private RecordHeldItemDetailsToDatabaseAdapter $detailAdapter;

    public function __construct(RecordHeldItemDetailsToDatabaseAdapter $detailAdapter)
    {
        $this->detailAdapter = $detailAdapter;
    }

    public function __invoke(Record $record): array
    {
        $heldItems = [];
        foreach ($record->pokemon()->heldItem() as $heldItem) {
            $id = Uuid::v4()->toRfc4122();
            $heldItems[] = [
                'id' => $id,
                'pokedex_id' => $record->id(),
                'item_name' => $heldItem->name(),
                'url' => $heldItem->url(),
                'details' => $this->detailAdapter->adapt($id, $heldItem->details())
            ];
        }
        return $heldItems;
    }

    public function adapt(Record $record): array
    {
        return $this($record);
    }
}