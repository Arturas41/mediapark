<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126161932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE supported_countries DROP FOREIGN KEY FK_53A65DD5AEBAE514');
        $this->addSql('DROP INDEX IDX_53A65DD5AEBAE514 ON supported_countries');
        $this->addSql('ALTER TABLE supported_countries CHANGE countries_id country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE supported_countries ADD CONSTRAINT FK_53A65DD5F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_53A65DD5F92F3E70 ON supported_countries (country_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE supported_countries DROP FOREIGN KEY FK_53A65DD5F92F3E70');
        $this->addSql('DROP INDEX IDX_53A65DD5F92F3E70 ON supported_countries');
        $this->addSql('ALTER TABLE supported_countries CHANGE country_id countries_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE supported_countries ADD CONSTRAINT FK_53A65DD5AEBAE514 FOREIGN KEY (countries_id) REFERENCES countries (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_53A65DD5AEBAE514 ON supported_countries (countries_id)');
    }
}
