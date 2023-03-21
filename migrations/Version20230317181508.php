<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230317181508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD concepto_caja_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7610B8325E FOREIGN KEY (concepto_caja_id) REFERENCES sub_cuenta (id)');
        $this->addSql('CREATE INDEX IDX_D8698A7610B8325E ON document (concepto_caja_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7610B8325E');
        $this->addSql('DROP INDEX IDX_D8698A7610B8325E ON document');
        $this->addSql('ALTER TABLE document DROP concepto_caja_id');
    }
}
