<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309135525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entidad_type_doc_entidad_field (entidad_type_doc_id INT NOT NULL, entidad_field_id INT NOT NULL, INDEX IDX_A85A9D831A5DC7D7 (entidad_type_doc_id), INDEX IDX_A85A9D8394B74641 (entidad_field_id), PRIMARY KEY(entidad_type_doc_id, entidad_field_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entidad_type_doc_entidad_field ADD CONSTRAINT FK_A85A9D831A5DC7D7 FOREIGN KEY (entidad_type_doc_id) REFERENCES entidad_type_doc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entidad_type_doc_entidad_field ADD CONSTRAINT FK_A85A9D8394B74641 FOREIGN KEY (entidad_field_id) REFERENCES entidad_field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entidad_entidad_field DROP FOREIGN KEY FK_8A0B16246CA204EF');
        $this->addSql('ALTER TABLE entidad_entidad_field DROP FOREIGN KEY FK_8A0B162494B74641');
        $this->addSql('DROP TABLE entidad_entidad_field');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entidad_entidad_field (entidad_id INT NOT NULL, entidad_field_id INT NOT NULL, INDEX IDX_8A0B162494B74641 (entidad_field_id), INDEX IDX_8A0B16246CA204EF (entidad_id), PRIMARY KEY(entidad_id, entidad_field_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE entidad_entidad_field ADD CONSTRAINT FK_8A0B16246CA204EF FOREIGN KEY (entidad_id) REFERENCES entidad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entidad_entidad_field ADD CONSTRAINT FK_8A0B162494B74641 FOREIGN KEY (entidad_field_id) REFERENCES entidad_field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entidad_type_doc_entidad_field DROP FOREIGN KEY FK_A85A9D831A5DC7D7');
        $this->addSql('ALTER TABLE entidad_type_doc_entidad_field DROP FOREIGN KEY FK_A85A9D8394B74641');
        $this->addSql('DROP TABLE entidad_type_doc_entidad_field');
    }
}
