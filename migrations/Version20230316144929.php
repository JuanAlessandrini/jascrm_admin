<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316144929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD detail_id INT NOT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76D8D003BB FOREIGN KEY (detail_id) REFERENCES document_detail (id)');
        $this->addSql('CREATE INDEX IDX_D8698A76D8D003BB ON document (detail_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76D8D003BB');
        $this->addSql('DROP INDEX IDX_D8698A76D8D003BB ON document');
        $this->addSql('ALTER TABLE document DROP detail_id');
    }
}
