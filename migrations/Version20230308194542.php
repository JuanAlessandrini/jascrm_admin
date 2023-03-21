<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308194542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounting_group2 ADD group1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE accounting_group2 ADD CONSTRAINT FK_7AF8BD953E2AAD79 FOREIGN KEY (group1_id) REFERENCES accounting_group1 (id)');
        $this->addSql('CREATE INDEX IDX_7AF8BD953E2AAD79 ON accounting_group2 (group1_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounting_group2 DROP FOREIGN KEY FK_7AF8BD953E2AAD79');
        $this->addSql('DROP INDEX IDX_7AF8BD953E2AAD79 ON accounting_group2');
        $this->addSql('ALTER TABLE accounting_group2 DROP group1_id');
    }
}
