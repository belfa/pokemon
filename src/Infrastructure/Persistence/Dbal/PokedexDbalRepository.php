<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Dbal;

use App\Domain\Pokemon\Pokedex\PokedexRepository;
use App\Domain\Pokemon\Pokedex\Record;
use App\Infrastructure\Transformer\Adapter\RecordToDatabaseAdapter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class PokedexDbalRepository implements PokedexRepository
{
    private const POKEDEX = Tables::POKEDEX_RECORD;
    private const SPRITE = Tables::POKEDEX_SPRITE;
    private const TYPE = Tables::POKEDEX_TYPE;
    private const HELD_ITEM = Tables::POKEDEX_HELD_ITEM;
    private const HELD_ITEM_DETAILS = Tables::POKEDEX_HELD_ITEM_DETAILS;

    public function __construct(
        private readonly Connection $connection,
        private readonly RecordToDatabaseAdapter $adapter
    )
    {
    }

    public function register(Record $record): void
    {
        try{
            $pokedex = $this->adapter->adapt($record);

            foreach ($pokedex['held_items'] as $heldItem) {
                foreach ($heldItem['details'] as $detail) {
                    $this->connection->insert(self::HELD_ITEM_DETAILS->tableName(), $detail);
                }
                unset($heldItem['details']);
                $this->connection->insert(self::HELD_ITEM->tableName(), $heldItem);
            }
            unset($pokedex['held_items']);

            foreach ($pokedex['types'] as $type) {
                $this->connection->insert(self::TYPE->tableName(), $type);
            }
            unset($pokedex['types']);

            foreach ($pokedex['sprites'] as $sprite) {
                $this->connection->insert(self::SPRITE->tableName(), $sprite);
            }
            unset($pokedex['sprites']);

            $this->connection->insert(self::POKEDEX->tableName(), $pokedex);
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
    }
}