<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329133019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cheque DROP FOREIGN KEY FK_A0BBFDE95AC41032');
        $this->addSql('ALTER TABLE cheque DROP FOREIGN KEY FK_A0BBFDE97DAB3BD2');
        $this->addSql('DROP INDEX IDX_A0BBFDE97DAB3BD2 ON cheque');
        $this->addSql('DROP INDEX IDX_A0BBFDE95AC41032 ON cheque');
        $this->addSql('ALTER TABLE cheque DROP librador_id, DROP movimiento_en_cuenta_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cheque ADD librador_id INT DEFAULT NULL, ADD movimiento_en_cuenta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cheque ADD CONSTRAINT FK_A0BBFDE95AC41032 FOREIGN KEY (movimiento_en_cuenta_id) REFERENCES bank_account (id)');
        $this->addSql('ALTER TABLE cheque ADD CONSTRAINT FK_A0BBFDE97DAB3BD2 FOREIGN KEY (librador_id) REFERENCES vendor (id)');
        $this->addSql('CREATE INDEX IDX_A0BBFDE97DAB3BD2 ON cheque (librador_id)');
        $this->addSql('CREATE INDEX IDX_A0BBFDE95AC41032 ON cheque (movimiento_en_cuenta_id)');
    }
}
