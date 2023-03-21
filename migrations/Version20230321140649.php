<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321140649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD cuenta_bancaria_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76619BC045 FOREIGN KEY (cuenta_bancaria_id) REFERENCES bank_account (id)');
        $this->addSql('CREATE INDEX IDX_D8698A76619BC045 ON document (cuenta_bancaria_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76619BC045');
        $this->addSql('DROP INDEX IDX_D8698A76619BC045 ON document');
        $this->addSql('ALTER TABLE document DROP cuenta_bancaria_id');
    }
}
