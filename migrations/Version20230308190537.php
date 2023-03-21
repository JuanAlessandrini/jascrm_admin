<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308190537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accounting_group1 (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accounting_group2 (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank_account (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, cbu BIGINT NOT NULL, sucursal VARCHAR(255) NOT NULL, INDEX IDX_53A23E0A9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuenta (id INT AUTO_INCREMENT NOT NULL, grupo_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_31C7BFCF9C833003 (grupo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuenta_auxiliar (id INT AUTO_INCREMENT NOT NULL, subcuenta_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C08FD04DE805A21 (subcuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movimiento_contable (id INT AUTO_INCREMENT NOT NULL, cuenta_id INT NOT NULL, cuenta_auxiliar_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, vendor_id INT DEFAULT NULL, created_at DATETIME NOT NULL, monto NUMERIC(20, 2) NOT NULL, INDEX IDX_1C36B9A59AEFF118 (cuenta_id), INDEX IDX_1C36B9A5E23C80CD (cuenta_auxiliar_id), INDEX IDX_1C36B9A59395C3F3 (customer_id), INDEX IDX_1C36B9A5F603EE73 (vendor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_cuenta (id INT AUTO_INCREMENT NOT NULL, cuenta_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_8396F0839AEFF118 (cuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bank_account ADD CONSTRAINT FK_53A23E0A9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE cuenta ADD CONSTRAINT FK_31C7BFCF9C833003 FOREIGN KEY (grupo_id) REFERENCES accounting_group2 (id)');
        $this->addSql('ALTER TABLE cuenta_auxiliar ADD CONSTRAINT FK_C08FD04DE805A21 FOREIGN KEY (subcuenta_id) REFERENCES sub_cuenta (id)');
        $this->addSql('ALTER TABLE movimiento_contable ADD CONSTRAINT FK_1C36B9A59AEFF118 FOREIGN KEY (cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE movimiento_contable ADD CONSTRAINT FK_1C36B9A5E23C80CD FOREIGN KEY (cuenta_auxiliar_id) REFERENCES cuenta_auxiliar (id)');
        $this->addSql('ALTER TABLE movimiento_contable ADD CONSTRAINT FK_1C36B9A59395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE movimiento_contable ADD CONSTRAINT FK_1C36B9A5F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE sub_cuenta ADD CONSTRAINT FK_8396F0839AEFF118 FOREIGN KEY (cuenta_id) REFERENCES cuenta (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank_account DROP FOREIGN KEY FK_53A23E0A9395C3F3');
        $this->addSql('ALTER TABLE cuenta DROP FOREIGN KEY FK_31C7BFCF9C833003');
        $this->addSql('ALTER TABLE cuenta_auxiliar DROP FOREIGN KEY FK_C08FD04DE805A21');
        $this->addSql('ALTER TABLE movimiento_contable DROP FOREIGN KEY FK_1C36B9A59AEFF118');
        $this->addSql('ALTER TABLE movimiento_contable DROP FOREIGN KEY FK_1C36B9A5E23C80CD');
        $this->addSql('ALTER TABLE movimiento_contable DROP FOREIGN KEY FK_1C36B9A59395C3F3');
        $this->addSql('ALTER TABLE movimiento_contable DROP FOREIGN KEY FK_1C36B9A5F603EE73');
        $this->addSql('ALTER TABLE sub_cuenta DROP FOREIGN KEY FK_8396F0839AEFF118');
        $this->addSql('DROP TABLE accounting_group1');
        $this->addSql('DROP TABLE accounting_group2');
        $this->addSql('DROP TABLE bank');
        $this->addSql('DROP TABLE bank_account');
        $this->addSql('DROP TABLE cuenta');
        $this->addSql('DROP TABLE cuenta_auxiliar');
        $this->addSql('DROP TABLE movimiento_contable');
        $this->addSql('DROP TABLE sub_cuenta');
    }
}
