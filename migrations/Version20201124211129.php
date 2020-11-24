<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124211129 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE supported_countries (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, holiday_api_id INT NOT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, UNIQUE INDEX UNIQ_53A65DD5F92F3E70 (country_id), UNIQUE INDEX UNIQ_53A65DD551BFD414 (holiday_api_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE supported_countries ADD CONSTRAINT FK_53A65DD5F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE supported_countries ADD CONSTRAINT FK_53A65DD551BFD414 FOREIGN KEY (holiday_api_id) REFERENCES holiday_apis (id)');
        $this->addSql('ALTER TABLE holiday_types ADD supported_countries_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE holiday_types ADD CONSTRAINT FK_708AB6F7DDA3177C FOREIGN KEY (supported_countries_id) REFERENCES supported_countries (id)');
        $this->addSql('CREATE INDEX IDX_708AB6F7DDA3177C ON holiday_types (supported_countries_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE holiday_types DROP FOREIGN KEY FK_708AB6F7DDA3177C');
        $this->addSql('DROP TABLE supported_countries');
        $this->addSql('DROP INDEX IDX_708AB6F7DDA3177C ON holiday_types');
        $this->addSql('ALTER TABLE holiday_types DROP supported_countries_id');
    }
}
