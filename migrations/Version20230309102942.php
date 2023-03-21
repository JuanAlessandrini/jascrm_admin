<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309102942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76C54C8C93');
        $this->addSql('ALTER TABLE document_field DROP FOREIGN KEY FK_3254332AC54C8C93');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76AA812384');
        $this->addSql('CREATE TABLE entidad (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, has_impuestos TINYINT(1) NOT NULL, has_perception TINYINT(1) NOT NULL, has_retencion TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidad_entidad_field (entidad_id INT NOT NULL, entidad_field_id INT NOT NULL, INDEX IDX_8A0B16246CA204EF (entidad_id), INDEX IDX_8A0B162494B74641 (entidad_field_id), PRIMARY KEY(entidad_id, entidad_field_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidad_field (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidad_type_doc (id INT AUTO_INCREMENT NOT NULL, entidad_id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(10) NOT NULL, signo INT NOT NULL, INDEX IDX_54D65A746CA204EF (entidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entidad_entidad_field ADD CONSTRAINT FK_8A0B16246CA204EF FOREIGN KEY (entidad_id) REFERENCES entidad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entidad_entidad_field ADD CONSTRAINT FK_8A0B162494B74641 FOREIGN KEY (entidad_field_id) REFERENCES entidad_field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entidad_type_doc ADD CONSTRAINT FK_54D65A746CA204EF FOREIGN KEY (entidad_id) REFERENCES entidad (id)');
        $this->addSql('ALTER TABLE entity_type_doc DROP FOREIGN KEY FK_26A2A7C581257D5D');
        $this->addSql('DROP TABLE entity');
        $this->addSql('DROP TABLE entity_field');
        $this->addSql('DROP TABLE entity_type_doc');
        $this->addSql('DROP INDEX IDX_D8698A76C54C8C93 ON document');
        $this->addSql('DROP INDEX IDX_D8698A76AA812384 ON document');
        $this->addSql('ALTER TABLE document ADD entidad_id INT DEFAULT NULL, DROP type_id, DROP type_doc_id');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A766CA204EF FOREIGN KEY (entidad_id) REFERENCES entidad (id)');
        $this->addSql('CREATE INDEX IDX_D8698A766CA204EF ON document (entidad_id)');
        $this->addSql('ALTER TABLE document_field DROP FOREIGN KEY FK_3254332AC33F7837');
        $this->addSql('DROP INDEX IDX_3254332AC33F7837 ON document_field');
        $this->addSql('DROP INDEX IDX_3254332AC54C8C93 ON document_field');
        $this->addSql('ALTER TABLE document_field DROP type_id, DROP document_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A766CA204EF');
        $this->addSql('CREATE TABLE entity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, has_impuestos TINYINT(1) NOT NULL, has_percepcion TINYINT(1) NOT NULL, has_retencion TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE entity_field (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE entity_type_doc (id INT AUTO_INCREMENT NOT NULL, entity_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, code VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, signo INT NOT NULL, INDEX IDX_26A2A7C581257D5D (entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE entity_type_doc ADD CONSTRAINT FK_26A2A7C581257D5D FOREIGN KEY (entity_id) REFERENCES entity (id)');
        $this->addSql('ALTER TABLE entidad_entidad_field DROP FOREIGN KEY FK_8A0B16246CA204EF');
        $this->addSql('ALTER TABLE entidad_entidad_field DROP FOREIGN KEY FK_8A0B162494B74641');
        $this->addSql('ALTER TABLE entidad_type_doc DROP FOREIGN KEY FK_54D65A746CA204EF');
        $this->addSql('DROP TABLE entidad');
        $this->addSql('DROP TABLE entidad_entidad_field');
        $this->addSql('DROP TABLE entidad_field');
        $this->addSql('DROP TABLE entidad_type_doc');
        $this->addSql('DROP INDEX IDX_D8698A766CA204EF ON document');
        $this->addSql('ALTER TABLE document ADD type_id INT NOT NULL, ADD type_doc_id INT NOT NULL, DROP entidad_id');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76C54C8C93 FOREIGN KEY (type_id) REFERENCES entity (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76AA812384 FOREIGN KEY (type_doc_id) REFERENCES entity_type_doc (id)');
        $this->addSql('CREATE INDEX IDX_D8698A76C54C8C93 ON document (type_id)');
        $this->addSql('CREATE INDEX IDX_D8698A76AA812384 ON document (type_doc_id)');
        $this->addSql('ALTER TABLE document_field ADD type_id INT NOT NULL, ADD document_id INT NOT NULL');
        $this->addSql('ALTER TABLE document_field ADD CONSTRAINT FK_3254332AC33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE document_field ADD CONSTRAINT FK_3254332AC54C8C93 FOREIGN KEY (type_id) REFERENCES entity_field (id)');
        $this->addSql('CREATE INDEX IDX_3254332AC33F7837 ON document_field (document_id)');
        $this->addSql('CREATE INDEX IDX_3254332AC54C8C93 ON document_field (type_id)');
    }
}
