<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316162158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76D8D003BB');
        $this->addSql('DROP INDEX IDX_D8698A76D8D003BB ON document');
        $this->addSql('ALTER TABLE document DROP detail_id');
        $this->addSql('ALTER TABLE document_detail ADD document_id INT NOT NULL');
        $this->addSql('ALTER TABLE document_detail ADD CONSTRAINT FK_9064CEF5C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('CREATE INDEX IDX_9064CEF5C33F7837 ON document_detail (document_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD detail_id INT NOT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76D8D003BB FOREIGN KEY (detail_id) REFERENCES document_detail (id)');
        $this->addSql('CREATE INDEX IDX_D8698A76D8D003BB ON document (detail_id)');
        $this->addSql('ALTER TABLE document_detail DROP FOREIGN KEY FK_9064CEF5C33F7837');
        $this->addSql('DROP INDEX IDX_9064CEF5C33F7837 ON document_detail');
        $this->addSql('ALTER TABLE document_detail DROP document_id');
    }
}
