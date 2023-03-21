<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308193101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD uid VARCHAR(32) NOT NULL, ADD date_created DATETIME NOT NULL, ADD date_modified DATETIME NOT NULL, ADD enabled TINYINT(1) DEFAULT 1, ADD deleted TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE document ADD uid VARCHAR(32) NOT NULL, ADD date_created DATETIME NOT NULL, ADD date_modified DATETIME NOT NULL, ADD enabled TINYINT(1) DEFAULT 1, ADD deleted TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE movimiento_contable ADD uid VARCHAR(32) NOT NULL, ADD date_created DATETIME NOT NULL, ADD date_modified DATETIME NOT NULL, ADD enabled TINYINT(1) DEFAULT 1, ADD deleted TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE vendor ADD uid VARCHAR(32) NOT NULL, ADD date_created DATETIME NOT NULL, ADD date_modified DATETIME NOT NULL, ADD enabled TINYINT(1) DEFAULT 1, ADD deleted TINYINT(1) DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP uid, DROP date_created, DROP date_modified, DROP enabled, DROP deleted');
        $this->addSql('ALTER TABLE document DROP uid, DROP date_created, DROP date_modified, DROP enabled, DROP deleted');
        $this->addSql('ALTER TABLE movimiento_contable DROP uid, DROP date_created, DROP date_modified, DROP enabled, DROP deleted');
        $this->addSql('ALTER TABLE vendor DROP uid, DROP date_created, DROP date_modified, DROP enabled, DROP deleted');
    }
}
