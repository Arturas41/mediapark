<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127231638 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE supported_country ADD from_date_year INT NOT NULL, ADD from_date_month INT NOT NULL, ADD form_date_day INT NOT NULL, ADD to_date_year INT NOT NULL, ADD to_date_month INT NOT NULL, ADD to_date_day INT NOT NULL, DROP from_date, DROP to_date');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE supported_country ADD from_date DATE NOT NULL, ADD to_date DATE NOT NULL, DROP from_date_year, DROP from_date_month, DROP form_date_day, DROP to_date_year, DROP to_date_month, DROP to_date_day');
    }
}
