<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Dbal;

enum Tables
{
    case POKEDEX_RECORD;
    case POKEDEX_SPRITE;
    case POKEDEX_TYPE;
    case POKEDEX_HELD_ITEM;
    case POKEDEX_HELD_ITEM_DETAILS;
    case SANCTUARY_RECORD;
    case SANCTUARY_SPRITE;
    case SANCTUARY_TYPE;
    case SANCTUARY_HELD_ITEM;
    case SANCTUARY_HELD_ITEM_DETAILS;

    public function tableName(): string
    {
        return match ($this)
        {
            Tables::POKEDEX_RECORD => 'pokedex',
            Tables::POKEDEX_SPRITE => 'pokedex_sprite',
            Tables::POKEDEX_TYPE => 'pokedex_type',
            Tables::POKEDEX_HELD_ITEM => 'pokedex_held_items',
            Tables::POKEDEX_HELD_ITEM_DETAILS => 'pokedex_held_item_version_details',
            Tables::SANCTUARY_RECORD => 'sanctuary',
            Tables::SANCTUARY_SPRITE => 'sanctuary_sprite',
            Tables::SANCTUARY_TYPE => 'sanctuary_type',
            Tables::SANCTUARY_HELD_ITEM => 'sanctuary_held_items',
            Tables::SANCTUARY_HELD_ITEM_DETAILS => 'sanctuary_held_item_version_details'
        };
    }
}