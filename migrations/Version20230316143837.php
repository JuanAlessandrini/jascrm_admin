<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316143837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document_sub_cuenta (document_id INT NOT NULL, sub_cuenta_id INT NOT NULL, INDEX IDX_22555BD5C33F7837 (document_id), INDEX IDX_22555BD588E2B7A6 (sub_cuenta_id), PRIMARY KEY(document_id, sub_cuenta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document_sub_cuenta ADD CONSTRAINT FK_22555BD5C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document_sub_cuenta ADD CONSTRAINT FK_22555BD588E2B7A6 FOREIGN KEY (sub_cuenta_id) REFERENCES sub_cuenta (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document_sub_cuenta DROP FOREIGN KEY FK_22555BD5C33F7837');
        $this->addSql('ALTER TABLE document_sub_cuenta DROP FOREIGN KEY FK_22555BD588E2B7A6');
        $this->addSql('DROP TABLE document_sub_cuenta');
    }
}
