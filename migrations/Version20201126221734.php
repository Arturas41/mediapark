<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126221734 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE supported_country DROP INDEX UNIQ_6C9CBA3351BFD414, ADD INDEX IDX_6C9CBA3351BFD414 (holiday_api_id)');
        $this->addSql('ALTER TABLE supported_country CHANGE holiday_api_id holiday_api_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE supported_country DROP INDEX IDX_6C9CBA3351BFD414, ADD UNIQUE INDEX UNIQ_6C9CBA3351BFD414 (holiday_api_id)');
        $this->addSql('ALTER TABLE supported_country CHANGE holiday_api_id holiday_api_id INT NOT NULL');
    }
}
