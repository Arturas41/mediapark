<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126225733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE supported_country DROP FOREIGN KEY FK_6C9CBA3351BFD414');
        $this->addSql('DROP TABLE holiday_api');
        $this->addSql('DROP INDEX IDX_6C9CBA3351BFD414 ON supported_country');
        $this->addSql('ALTER TABLE supported_country DROP holiday_api_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE holiday_api (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE supported_country ADD holiday_api_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE supported_country ADD CONSTRAINT FK_6C9CBA3351BFD414 FOREIGN KEY (holiday_api_id) REFERENCES holiday_api (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6C9CBA3351BFD414 ON supported_country (holiday_api_id)');
    }
}
