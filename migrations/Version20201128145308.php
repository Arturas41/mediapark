<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201128145308 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE holiday_type (id INT AUTO_INCREMENT NOT NULL, supported_country_id INT DEFAULT NULL, code_name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, short_description VARCHAR(255) NOT NULL, INDEX IDX_EF280850A7FF07C8 (supported_country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supported_country (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, from_date_year INT NOT NULL, from_date_month INT NOT NULL, from_date_day INT NOT NULL, to_date_year INT NOT NULL, to_date_month INT NOT NULL, to_date_day INT NOT NULL, UNIQUE INDEX UNIQ_6C9CBA33F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE holiday_type ADD CONSTRAINT FK_EF280850A7FF07C8 FOREIGN KEY (supported_country_id) REFERENCES supported_country (id)');
        $this->addSql('ALTER TABLE supported_country ADD CONSTRAINT FK_6C9CBA33F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE supported_country DROP FOREIGN KEY FK_6C9CBA33F92F3E70');
        $this->addSql('ALTER TABLE holiday_type DROP FOREIGN KEY FK_EF280850A7FF07C8');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE holiday_type');
        $this->addSql('DROP TABLE supported_country');
        $this->addSql('DROP TABLE user');
    }
}
