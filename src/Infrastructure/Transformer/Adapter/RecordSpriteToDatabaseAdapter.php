<?php

declare(strict_types=1);

namespace App\Infrastructure\Transformer\Adapter;

use App\Domain\Pokemon\Pokedex\Record;

final class RecordSpriteToDatabaseAdapter
{
    public function __invoke(Record $record): array
    {
        $sprites = [];
        foreach ($record->pokemon()->sprites() as $sprite) {
             $sprites[] = [
                'pokedex_id' => $record->id(),
                'url' => $sprite->url()
            ];
        }
        return $sprites;
    }

    public function adapt(Record $record): array
    {
        return $this($record);
    }
}