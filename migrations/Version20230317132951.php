<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230317132951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document_impuesto DROP FOREIGN KEY FK_3927CBF8C54C8C93');
        $this->addSql('ALTER TABLE document_impuesto ADD CONSTRAINT FK_3927CBF8C54C8C93 FOREIGN KEY (type_id) REFERENCES sub_cuenta (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document_impuesto DROP FOREIGN KEY FK_3927CBF8C54C8C93');
        $this->addSql('ALTER TABLE document_impuesto ADD CONSTRAINT FK_3927CBF8C54C8C93 FOREIGN KEY (type_id) REFERENCES impuesto (id)');
    }
}
