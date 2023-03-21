<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313180531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD tipo_id INT NOT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76A9276E6C FOREIGN KEY (tipo_id) REFERENCES entidad_type_doc (id)');
        $this->addSql('CREATE INDEX IDX_D8698A76A9276E6C ON document (tipo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76A9276E6C');
        $this->addSql('DROP INDEX IDX_D8698A76A9276E6C ON document');
        $this->addSql('ALTER TABLE document DROP tipo_id');
    }
}
