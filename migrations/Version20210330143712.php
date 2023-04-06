<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330143712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accounting_group1 (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accounting_group2 (id INT AUTO_INCREMENT NOT NULL, group1_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_7AF8BD953E2AAD79 (group1_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank_account (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, banco_id INT NOT NULL, cbu VARCHAR(22) NOT NULL, sucursal VARCHAR(255) NOT NULL, INDEX IDX_53A23E0A9395C3F3 (customer_id), INDEX IDX_53A23E0ACC04A73E (banco_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cheque (id INT AUTO_INCREMENT NOT NULL, banco_id INT NOT NULL, document_id INT NOT NULL, numero VARCHAR(30) NOT NULL, vencimiento DATETIME NOT NULL, sucursal VARCHAR(50) DEFAULT NULL, monto NUMERIC(15, 2) NOT NULL, INDEX IDX_A0BBFDE9CC04A73E (banco_id), INDEX IDX_A0BBFDE9C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuenta (id INT AUTO_INCREMENT NOT NULL, grupo_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_31C7BFCF9C833003 (grupo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuenta_auxiliar (id INT AUTO_INCREMENT NOT NULL, subcuenta_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C08FD04DE805A21 (subcuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuenta_bancaria (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, banco VARCHAR(255) NOT NULL, cbu VARCHAR(22) NOT NULL, sucursal VARCHAR(255) NOT NULL, INDEX IDX_ECD0C9CEDE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(32) NOT NULL, date_created DATETIME NOT NULL, date_modified DATETIME NOT NULL, enabled TINYINT(1) DEFAULT 1, deleted TINYINT(1) DEFAULT 0, name VARCHAR(255) NOT NULL, cuit VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, campanias VARCHAR(255) DEFAULT NULL, sucursales VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, customer_id INT NOT NULL, vendor_id INT NOT NULL, entidad_id INT DEFAULT NULL, tipo_id INT NOT NULL, concepto_caja_id INT DEFAULT NULL, cuenta_bancaria_id INT DEFAULT NULL, grano_id INT DEFAULT NULL, uid VARCHAR(32) NOT NULL, date_created DATETIME NOT NULL, date_modified DATETIME NOT NULL, enabled TINYINT(1) DEFAULT 1, deleted TINYINT(1) DEFAULT 0, created_at DATETIME DEFAULT NULL, modified_at DATETIME NOT NULL, campania VARCHAR(255) DEFAULT NULL, codigo VARCHAR(10) DEFAULT NULL, numero BIGINT DEFAULT NULL, total NUMERIC(15, 2) NOT NULL, sucursal VARCHAR(255) DEFAULT NULL, emisor VARCHAR(10) DEFAULT NULL, subtotal NUMERIC(15, 2) DEFAULT NULL, medio_pago VARCHAR(30) DEFAULT NULL, INDEX IDX_D8698A76B03A8386 (created_by_id), INDEX IDX_D8698A7699049ECE (modified_by_id), INDEX IDX_D8698A769395C3F3 (customer_id), INDEX IDX_D8698A76F603EE73 (vendor_id), INDEX IDX_D8698A766CA204EF (entidad_id), INDEX IDX_D8698A76A9276E6C (tipo_id), INDEX IDX_D8698A7610B8325E (concepto_caja_id), INDEX IDX_D8698A76619BC045 (cuenta_bancaria_id), INDEX IDX_D8698A76DB14596D (grano_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_detail (id INT AUTO_INCREMENT NOT NULL, concepto_id INT NOT NULL, document_id INT NOT NULL, ammount NUMERIC(15, 2) NOT NULL, cantidad NUMERIC(10, 2) NOT NULL, INDEX IDX_9064CEF56C2330BD (concepto_id), INDEX IDX_9064CEF5C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_field (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_impuesto (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, document_id INT NOT NULL, value NUMERIC(15, 2) NOT NULL, INDEX IDX_3927CBF8C54C8C93 (type_id), INDEX IDX_3927CBF8C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_percepcion (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, document_id INT NOT NULL, ammount NUMERIC(15, 2) NOT NULL, INDEX IDX_71CEAF95C54C8C93 (type_id), INDEX IDX_71CEAF95C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_retention (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, document_id INT DEFAULT NULL, ammount NUMERIC(15, 2) NOT NULL, INDEX IDX_3F47262DC54C8C93 (type_id), INDEX IDX_3F47262DC33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidad (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, has_impuestos TINYINT(1) NOT NULL, has_perception TINYINT(1) NOT NULL, has_retencion TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidad_field (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidad_type_doc (id INT AUTO_INCREMENT NOT NULL, entidad_id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(10) NOT NULL, signo INT NOT NULL, INDEX IDX_54D65A746CA204EF (entidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidad_type_doc_entidad_field (entidad_type_doc_id INT NOT NULL, entidad_field_id INT NOT NULL, INDEX IDX_A85A9D831A5DC7D7 (entidad_type_doc_id), INDEX IDX_A85A9D8394B74641 (entidad_field_id), PRIMARY KEY(entidad_type_doc_id, entidad_field_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grano (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, short VARCHAR(4) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movimiento_contable (id INT AUTO_INCREMENT NOT NULL, cuenta_id INT NOT NULL, cuenta_auxiliar_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, vendor_id INT DEFAULT NULL, uid VARCHAR(32) NOT NULL, date_created DATETIME NOT NULL, date_modified DATETIME NOT NULL, enabled TINYINT(1) DEFAULT 1, deleted TINYINT(1) DEFAULT 0, created_at DATETIME NOT NULL, monto NUMERIC(20, 2) NOT NULL, INDEX IDX_1C36B9A59AEFF118 (cuenta_id), INDEX IDX_1C36B9A5E23C80CD (cuenta_auxiliar_id), INDEX IDX_1C36B9A59395C3F3 (customer_id), INDEX IDX_1C36B9A5F603EE73 (vendor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_cuenta (id INT AUTO_INCREMENT NOT NULL, cuenta_id INT NOT NULL, name VARCHAR(255) NOT NULL, tipo VARCHAR(255) NOT NULL, INDEX IDX_8396F0839AEFF118 (cuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, default_cliente_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64996501A32 (default_cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(32) NOT NULL, date_created DATETIME NOT NULL, date_modified DATETIME NOT NULL, enabled TINYINT(1) DEFAULT 1, deleted TINYINT(1) DEFAULT 0, name VARCHAR(255) NOT NULL, cuit VARCHAR(20) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accounting_group2 ADD CONSTRAINT FK_7AF8BD953E2AAD79 FOREIGN KEY (group1_id) REFERENCES accounting_group1 (id)');
        $this->addSql('ALTER TABLE bank_account ADD CONSTRAINT FK_53A23E0A9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE bank_account ADD CONSTRAINT FK_53A23E0ACC04A73E FOREIGN KEY (banco_id) REFERENCES bank (id)');
        $this->addSql('ALTER TABLE cheque ADD CONSTRAINT FK_A0BBFDE9CC04A73E FOREIGN KEY (banco_id) REFERENCES bank (id)');
        $this->addSql('ALTER TABLE cheque ADD CONSTRAINT FK_A0BBFDE9C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE cuenta ADD CONSTRAINT FK_31C7BFCF9C833003 FOREIGN KEY (grupo_id) REFERENCES accounting_group2 (id)');
        $this->addSql('ALTER TABLE cuenta_auxiliar ADD CONSTRAINT FK_C08FD04DE805A21 FOREIGN KEY (subcuenta_id) REFERENCES sub_cuenta (id)');
        $this->addSql('ALTER TABLE cuenta_bancaria ADD CONSTRAINT FK_ECD0C9CEDE734E51 FOREIGN KEY (cliente_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7699049ECE FOREIGN KEY (modified_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A769395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A766CA204EF FOREIGN KEY (entidad_id) REFERENCES entidad (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76A9276E6C FOREIGN KEY (tipo_id) REFERENCES entidad_type_doc (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7610B8325E FOREIGN KEY (concepto_caja_id) REFERENCES sub_cuenta (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76619BC045 FOREIGN KEY (cuenta_bancaria_id) REFERENCES bank_account (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76DB14596D FOREIGN KEY (grano_id) REFERENCES grano (id)');
        $this->addSql('ALTER TABLE document_detail ADD CONSTRAINT FK_9064CEF56C2330BD FOREIGN KEY (concepto_id) REFERENCES sub_cuenta (id)');
        $this->addSql('ALTER TABLE document_detail ADD CONSTRAINT FK_9064CEF5C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE document_impuesto ADD CONSTRAINT FK_3927CBF8C54C8C93 FOREIGN KEY (type_id) REFERENCES sub_cuenta (id)');
        $this->addSql('ALTER TABLE document_impuesto ADD CONSTRAINT FK_3927CBF8C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE document_percepcion ADD CONSTRAINT FK_71CEAF95C54C8C93 FOREIGN KEY (type_id) REFERENCES sub_cuenta (id)');
        $this->addSql('ALTER TABLE document_percepcion ADD CONSTRAINT FK_71CEAF95C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE document_retention ADD CONSTRAINT FK_3F47262DC54C8C93 FOREIGN KEY (type_id) REFERENCES sub_cuenta (id)');
        $this->addSql('ALTER TABLE document_retention ADD CONSTRAINT FK_3F47262DC33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE entidad_type_doc ADD CONSTRAINT FK_54D65A746CA204EF FOREIGN KEY (entidad_id) REFERENCES entidad (id)');
        $this->addSql('ALTER TABLE entidad_type_doc_entidad_field ADD CONSTRAINT FK_A85A9D831A5DC7D7 FOREIGN KEY (entidad_type_doc_id) REFERENCES entidad_type_doc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entidad_type_doc_entidad_field ADD CONSTRAINT FK_A85A9D8394B74641 FOREIGN KEY (entidad_field_id) REFERENCES entidad_field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movimiento_contable ADD CONSTRAINT FK_1C36B9A59AEFF118 FOREIGN KEY (cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE movimiento_contable ADD CONSTRAINT FK_1C36B9A5E23C80CD FOREIGN KEY (cuenta_auxiliar_id) REFERENCES cuenta_auxiliar (id)');
        $this->addSql('ALTER TABLE movimiento_contable ADD CONSTRAINT FK_1C36B9A59395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE movimiento_contable ADD CONSTRAINT FK_1C36B9A5F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE sub_cuenta ADD CONSTRAINT FK_8396F0839AEFF118 FOREIGN KEY (cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64996501A32 FOREIGN KEY (default_cliente_id) REFERENCES customer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounting_group2 DROP FOREIGN KEY FK_7AF8BD953E2AAD79');
        $this->addSql('ALTER TABLE bank_account DROP FOREIGN KEY FK_53A23E0A9395C3F3');
        $this->addSql('ALTER TABLE bank_account DROP FOREIGN KEY FK_53A23E0ACC04A73E');
        $this->addSql('ALTER TABLE cheque DROP FOREIGN KEY FK_A0BBFDE9CC04A73E');
        $this->addSql('ALTER TABLE cheque DROP FOREIGN KEY FK_A0BBFDE9C33F7837');
        $this->addSql('ALTER TABLE cuenta DROP FOREIGN KEY FK_31C7BFCF9C833003');
        $this->addSql('ALTER TABLE cuenta_auxiliar DROP FOREIGN KEY FK_C08FD04DE805A21');
        $this->addSql('ALTER TABLE cuenta_bancaria DROP FOREIGN KEY FK_ECD0C9CEDE734E51');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76B03A8386');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7699049ECE');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A769395C3F3');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76F603EE73');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A766CA204EF');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76A9276E6C');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7610B8325E');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76619BC045');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76DB14596D');
        $this->addSql('ALTER TABLE document_detail DROP FOREIGN KEY FK_9064CEF56C2330BD');
        $this->addSql('ALTER TABLE document_detail DROP FOREIGN KEY FK_9064CEF5C33F7837');
        $this->addSql('ALTER TABLE document_impuesto DROP FOREIGN KEY FK_3927CBF8C54C8C93');
        $this->addSql('ALTER TABLE document_impuesto DROP FOREIGN KEY FK_3927CBF8C33F7837');
        $this->addSql('ALTER TABLE document_percepcion DROP FOREIGN KEY FK_71CEAF95C54C8C93');
        $this->addSql('ALTER TABLE document_percepcion DROP FOREIGN KEY FK_71CEAF95C33F7837');
        $this->addSql('ALTER TABLE document_retention DROP FOREIGN KEY FK_3F47262DC54C8C93');
        $this->addSql('ALTER TABLE document_retention DROP FOREIGN KEY FK_3F47262DC33F7837');
        $this->addSql('ALTER TABLE entidad_type_doc DROP FOREIGN KEY FK_54D65A746CA204EF');
        $this->addSql('ALTER TABLE entidad_type_doc_entidad_field DROP FOREIGN KEY FK_A85A9D831A5DC7D7');
        $this->addSql('ALTER TABLE entidad_type_doc_entidad_field DROP FOREIGN KEY FK_A85A9D8394B74641');
        $this->addSql('ALTER TABLE movimiento_contable DROP FOREIGN KEY FK_1C36B9A59AEFF118');
        $this->addSql('ALTER TABLE movimiento_contable DROP FOREIGN KEY FK_1C36B9A5E23C80CD');
        $this->addSql('ALTER TABLE movimiento_contable DROP FOREIGN KEY FK_1C36B9A59395C3F3');
        $this->addSql('ALTER TABLE movimiento_contable DROP FOREIGN KEY FK_1C36B9A5F603EE73');
        $this->addSql('ALTER TABLE sub_cuenta DROP FOREIGN KEY FK_8396F0839AEFF118');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64996501A32');
        $this->addSql('DROP TABLE accounting_group1');
        $this->addSql('DROP TABLE accounting_group2');
        $this->addSql('DROP TABLE bank');
        $this->addSql('DROP TABLE bank_account');
        $this->addSql('DROP TABLE cheque');
        $this->addSql('DROP TABLE cuenta');
        $this->addSql('DROP TABLE cuenta_auxiliar');
        $this->addSql('DROP TABLE cuenta_bancaria');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE document_detail');
        $this->addSql('DROP TABLE document_field');
        $this->addSql('DROP TABLE document_impuesto');
        $this->addSql('DROP TABLE document_percepcion');
        $this->addSql('DROP TABLE document_retention');
        $this->addSql('DROP TABLE entidad');
        $this->addSql('DROP TABLE entidad_field');
        $this->addSql('DROP TABLE entidad_type_doc');
        $this->addSql('DROP TABLE entidad_type_doc_entidad_field');
        $this->addSql('DROP TABLE grano');
        $this->addSql('DROP TABLE movimiento_contable');
        $this->addSql('DROP TABLE sub_cuenta');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vendor');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
