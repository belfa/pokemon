<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Dbal;

use App\Domain\Pokemon\Sanctuary\SanctuaryRepository;
use App\Domain\Pokemon\Wild\Pokemon;
use App\Infrastructure\Transformer\Adapter\PokemonToSanctuaryAdapter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class SanctuaryDbalRepository implements SanctuaryRepository
{

    private const SANCTUARY = Tables::SANCTUARY_RECORD;
    private const SPRITE = Tables::SANCTUARY_SPRITE;
    private const TYPE = Tables::SANCTUARY_TYPE;
    private const HELD_ITEM = Tables::SANCTUARY_HELD_ITEM;
    private const HELD_ITEM_DETAILS = Tables::SANCTUARY_HELD_ITEM_DETAILS;

    public function __construct(
        private readonly Connection $connection,
        private readonly PokemonToSanctuaryAdapter $adapter
    )
    {
    }

    public function release(Pokemon $pokemon): void
    {
        try {
            $pokemonRaw = $this->adapter->adapt($pokemon);

            foreach ($pokemonRaw['held_items'] as $heldItem) {
                foreach ($heldItem['details'] as $detail) {
                    $this->connection->insert(self::HELD_ITEM_DETAILS->tableName(), $detail);
                }
                unset($heldItem['details']);

                $this->connection->insert(self::HELD_ITEM->tableName(), $heldItem);
            }
            unset($pokemonRaw['held_items']);

            foreach ($pokemonRaw['types'] as $type) {
                $this->connection->insert(self::TYPE->tableName(), $type);
            }
            unset($pokemonRaw['types']);

            foreach ($pokemonRaw['sprites'] as $sprite) {
                $this->connection->insert(self::SPRITE->tableName(), $sprite);
            }
            unset($pokemonRaw['sprites']);

            $this->connection->insert(self::SANCTUARY->tableName(), $pokemonRaw);
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
    }
}