<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321191020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document_percepcion (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, document_id INT NOT NULL, ammount NUMERIC(15, 2) NOT NULL, INDEX IDX_71CEAF95C54C8C93 (type_id), INDEX IDX_71CEAF95C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_retention (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, document_id INT DEFAULT NULL, ammount NUMERIC(15, 2) NOT NULL, INDEX IDX_3F47262DC54C8C93 (type_id), INDEX IDX_3F47262DC33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document_percepcion ADD CONSTRAINT FK_71CEAF95C54C8C93 FOREIGN KEY (type_id) REFERENCES sub_cuenta (id)');
        $this->addSql('ALTER TABLE document_percepcion ADD CONSTRAINT FK_71CEAF95C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE document_retention ADD CONSTRAINT FK_3F47262DC54C8C93 FOREIGN KEY (type_id) REFERENCES sub_cuenta (id)');
        $this->addSql('ALTER TABLE document_retention ADD CONSTRAINT FK_3F47262DC33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document_percepcion DROP FOREIGN KEY FK_71CEAF95C54C8C93');
        $this->addSql('ALTER TABLE document_percepcion DROP FOREIGN KEY FK_71CEAF95C33F7837');
        $this->addSql('ALTER TABLE document_retention DROP FOREIGN KEY FK_3F47262DC54C8C93');
        $this->addSql('ALTER TABLE document_retention DROP FOREIGN KEY FK_3F47262DC33F7837');
        $this->addSql('DROP TABLE document_percepcion');
        $this->addSql('DROP TABLE document_retention');
    }
}
