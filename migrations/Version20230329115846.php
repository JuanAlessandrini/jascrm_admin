<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329115846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cheque (id INT AUTO_INCREMENT NOT NULL, banco_id INT NOT NULL, librador_id INT DEFAULT NULL, movimiento_en_cuenta_id INT DEFAULT NULL, numero VARCHAR(30) NOT NULL, vencimiento DATETIME NOT NULL, sucursal VARCHAR(50) NOT NULL, monto NUMERIC(15, 2) NOT NULL, INDEX IDX_A0BBFDE9CC04A73E (banco_id), INDEX IDX_A0BBFDE97DAB3BD2 (librador_id), INDEX IDX_A0BBFDE95AC41032 (movimiento_en_cuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cheque ADD CONSTRAINT FK_A0BBFDE9CC04A73E FOREIGN KEY (banco_id) REFERENCES bank (id)');
        $this->addSql('ALTER TABLE cheque ADD CONSTRAINT FK_A0BBFDE97DAB3BD2 FOREIGN KEY (librador_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE cheque ADD CONSTRAINT FK_A0BBFDE95AC41032 FOREIGN KEY (movimiento_en_cuenta_id) REFERENCES bank_account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cheque DROP FOREIGN KEY FK_A0BBFDE9CC04A73E');
        $this->addSql('ALTER TABLE cheque DROP FOREIGN KEY FK_A0BBFDE97DAB3BD2');
        $this->addSql('ALTER TABLE cheque DROP FOREIGN KEY FK_A0BBFDE95AC41032');
        $this->addSql('DROP TABLE cheque');
    }
}
