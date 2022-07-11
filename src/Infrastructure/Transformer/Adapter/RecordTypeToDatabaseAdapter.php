<?php
declare(strict_types=1);

namespace App\Infrastructure\Transformer\Adapter;

use App\Domain\Pokemon\Pokedex\Record;
use Symfony\Component\Uid\Uuid;

final class RecordTypeToDatabaseAdapter
{
    public function __invoke(Record $record): array
    {
        $types = [];
        foreach ($record->pokemon()->types() as $type) {
            $types[] = [
                'id' => Uuid::v4()->toRfc4122(),
                'pokedex_id' => $record->id(),
                'name' => $type->name(),
                'url' => $type->url()
            ];
        }
        return $types;
    }

    public function adapt(Record $record): array
    {
        return $this($record);
    }

}