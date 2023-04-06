<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330192758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reporte (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reporte_sub_cuenta (reporte_id INT NOT NULL, sub_cuenta_id INT NOT NULL, INDEX IDX_AFDB759692CA572 (reporte_id), INDEX IDX_AFDB759688E2B7A6 (sub_cuenta_id), PRIMARY KEY(reporte_id, sub_cuenta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reporte_entidad_type_doc (reporte_id INT NOT NULL, entidad_type_doc_id INT NOT NULL, INDEX IDX_26E2C9DA92CA572 (reporte_id), INDEX IDX_26E2C9DA1A5DC7D7 (entidad_type_doc_id), PRIMARY KEY(reporte_id, entidad_type_doc_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reporte_sub_cuenta ADD CONSTRAINT FK_AFDB759692CA572 FOREIGN KEY (reporte_id) REFERENCES reporte (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reporte_sub_cuenta ADD CONSTRAINT FK_AFDB759688E2B7A6 FOREIGN KEY (sub_cuenta_id) REFERENCES sub_cuenta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reporte_entidad_type_doc ADD CONSTRAINT FK_26E2C9DA92CA572 FOREIGN KEY (reporte_id) REFERENCES reporte (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reporte_entidad_type_doc ADD CONSTRAINT FK_26E2C9DA1A5DC7D7 FOREIGN KEY (entidad_type_doc_id) REFERENCES entidad_type_doc (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reporte_sub_cuenta DROP FOREIGN KEY FK_AFDB759692CA572');
        $this->addSql('ALTER TABLE reporte_sub_cuenta DROP FOREIGN KEY FK_AFDB759688E2B7A6');
        $this->addSql('ALTER TABLE reporte_entidad_type_doc DROP FOREIGN KEY FK_26E2C9DA92CA572');
        $this->addSql('ALTER TABLE reporte_entidad_type_doc DROP FOREIGN KEY FK_26E2C9DA1A5DC7D7');
        $this->addSql('DROP TABLE reporte');
        $this->addSql('DROP TABLE reporte_sub_cuenta');
        $this->addSql('DROP TABLE reporte_entidad_type_doc');
    }
}
