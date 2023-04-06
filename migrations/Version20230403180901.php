<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403180901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reporte_entidad_field (reporte_id INT NOT NULL, entidad_field_id INT NOT NULL, INDEX IDX_E88EBE9A92CA572 (reporte_id), INDEX IDX_E88EBE9A94B74641 (entidad_field_id), PRIMARY KEY(reporte_id, entidad_field_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reporte_entidad_field ADD CONSTRAINT FK_E88EBE9A92CA572 FOREIGN KEY (reporte_id) REFERENCES reporte (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reporte_entidad_field ADD CONSTRAINT FK_E88EBE9A94B74641 FOREIGN KEY (entidad_field_id) REFERENCES entidad_field (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reporte_entidad_field DROP FOREIGN KEY FK_E88EBE9A92CA572');
        $this->addSql('ALTER TABLE reporte_entidad_field DROP FOREIGN KEY FK_E88EBE9A94B74641');
        $this->addSql('DROP TABLE reporte_entidad_field');
    }
}
