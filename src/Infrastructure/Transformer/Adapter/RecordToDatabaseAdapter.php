<?php
declare(strict_types=1);

namespace App\Infrastructure\Transformer\Adapter;

use App\Domain\Pokemon\Pokedex\Record;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;

final class RecordToDatabaseAdapter
{
    private RecordSpriteToDatabaseAdapter $spriteToDatabaseAdapter;
    private RecordTypeToDatabaseAdapter $typeToDatabaseAdapter;
    private RecordHeldItemsToDatabaseAdapter $heldItemsToDatabaseAdapter;

    public function __construct(
        RecordSpriteToDatabaseAdapter $spriteToDatabaseAdapter,
        RecordTypeToDatabaseAdapter   $typeToDatabaseAdapter,
        RecordHeldItemsToDatabaseAdapter $heldItemsToDatabaseAdapter
    )
    {
        $this->spriteToDatabaseAdapter = $spriteToDatabaseAdapter;
        $this->typeToDatabaseAdapter = $typeToDatabaseAdapter;
        $this->heldItemsToDatabaseAdapter = $heldItemsToDatabaseAdapter;
    }

    #[ArrayShape(
        [
            'id' => "string",
            'pokemon_code' => "int",
            'name' => "string",
            'date_of_capture' => "int",
            'sprites' => "array",
            'types' => "array",
            'held_items' => "array"
        ]
    )]
    public function __invoke(Record $record): array
    {
        return [
            'id' => $record->id(),
            'pokemon_code' => $record->pokemon()->id(),
            'name' => $record->pokemon()->name(),
            'date_of_capture' => (new DateTime)
                ->setTimestamp((int)$record->pokemon()->dateOfCapture())
                ->format('Y-m-d h:i:s'),
            'sprites' => $this->spriteToDatabaseAdapter->adapt($record),
            'types' => $this->typeToDatabaseAdapter->adapt($record),
            'held_items' => $this->heldItemsToDatabaseAdapter->adapt($record)
        ];
    }

    #[ArrayShape(
        [
            'id' => "string",
            'pokemon_code' => "int",
            'name' => "string",
            'date_of_capture' => "int",
            'sprites' => 'array',
            'types' => 'array',
            'held_items' => "array"
        ]
    )]
    public function adapt(Record $record): array
    {
        return $this($record);
    }
}