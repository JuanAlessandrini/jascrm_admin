<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321124734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank_account ADD banco_id INT NOT NULL');
        $this->addSql('ALTER TABLE bank_account ADD CONSTRAINT FK_53A23E0ACC04A73E FOREIGN KEY (banco_id) REFERENCES bank (id)');
        $this->addSql('CREATE INDEX IDX_53A23E0ACC04A73E ON bank_account (banco_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank_account DROP FOREIGN KEY FK_53A23E0ACC04A73E');
        $this->addSql('DROP INDEX IDX_53A23E0ACC04A73E ON bank_account');
        $this->addSql('ALTER TABLE bank_account DROP banco_id');
    }
}
