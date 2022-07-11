<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220701102635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Table pokedex to basic data pokemon up!';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('create table pokemon
                            (
                                id              int                                not null,
                                pokemon_code    int                                not null,
                                name            varchar(200)                       not null,
                                date_of_capture timestamp                          not null,
                                date_created    datetime default current_timestamp not null,
                                constraint pokemon_pk
                                    primary key (id)
                            )');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table pokemon');

    }
}