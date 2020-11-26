<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126174852 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE supported_countries DROP FOREIGN KEY FK_53A65DD5F92F3E70');
        $this->addSql('ALTER TABLE supported_countries DROP FOREIGN KEY FK_53A65DD551BFD414');
        $this->addSql('ALTER TABLE holiday_types DROP FOREIGN KEY FK_708AB6F7DDA3177C');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE holiday_api (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE holiday_type (id INT AUTO_INCREMENT NOT NULL, supported_country_id INT DEFAULT NULL, code_name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, short_description VARCHAR(255) NOT NULL, INDEX IDX_EF280850A7FF07C8 (supported_country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supported_country (id INT AUTO_INCREMENT NOT NULL, holiday_api_id INT NOT NULL, country_id INT DEFAULT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, UNIQUE INDEX UNIQ_6C9CBA3351BFD414 (holiday_api_id), INDEX IDX_6C9CBA33F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE holiday_type ADD CONSTRAINT FK_EF280850A7FF07C8 FOREIGN KEY (supported_country_id) REFERENCES supported_country (id)');
        $this->addSql('ALTER TABLE supported_country ADD CONSTRAINT FK_6C9CBA3351BFD414 FOREIGN KEY (holiday_api_id) REFERENCES holiday_api (id)');
        $this->addSql('ALTER TABLE supported_country ADD CONSTRAINT FK_6C9CBA33F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE holiday_apis');
        $this->addSql('DROP TABLE holiday_types');
        $this->addSql('DROP TABLE supported_countries');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE supported_country DROP FOREIGN KEY FK_6C9CBA33F92F3E70');
        $this->addSql('ALTER TABLE supported_country DROP FOREIGN KEY FK_6C9CBA3351BFD414');
        $this->addSql('ALTER TABLE holiday_type DROP FOREIGN KEY FK_EF280850A7FF07C8');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, code VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE holiday_apis (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE holiday_types (id INT AUTO_INCREMENT NOT NULL, supported_countries_id INT DEFAULT NULL, code_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, short_description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_708AB6F7DDA3177C (supported_countries_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE supported_countries (id INT AUTO_INCREMENT NOT NULL, holiday_api_id INT NOT NULL, country_id INT DEFAULT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, INDEX IDX_53A65DD5F92F3E70 (country_id), UNIQUE INDEX UNIQ_53A65DD551BFD414 (holiday_api_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE holiday_types ADD CONSTRAINT FK_708AB6F7DDA3177C FOREIGN KEY (supported_countries_id) REFERENCES supported_countries (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE supported_countries ADD CONSTRAINT FK_53A65DD551BFD414 FOREIGN KEY (holiday_api_id) REFERENCES holiday_apis (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE supported_countries ADD CONSTRAINT FK_53A65DD5F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE holiday_api');
        $this->addSql('DROP TABLE holiday_type');
        $this->addSql('DROP TABLE supported_country');
    }
}
