<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221121033310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("UPDATE `leoadmin`.`user` SET `roles` = '[\"ROLE_ADMIN\"]' WHERE (`id` = '1');");
        $this->addSql("UPDATE `leoadmin`.`user` SET `roles` = '[\"ROLE_ADMIN\"]' WHERE (`id` = '2');");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
