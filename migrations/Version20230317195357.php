<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230317195357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cuenta_bancaria (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, banco VARCHAR(255) NOT NULL, cbu VARCHAR(22) NOT NULL, sucursal VARCHAR(255) NOT NULL, INDEX IDX_ECD0C9CEDE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cuenta_bancaria ADD CONSTRAINT FK_ECD0C9CEDE734E51 FOREIGN KEY (cliente_id) REFERENCES customer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cuenta_bancaria DROP FOREIGN KEY FK_ECD0C9CEDE734E51');
        $this->addSql('DROP TABLE cuenta_bancaria');
    }
}
