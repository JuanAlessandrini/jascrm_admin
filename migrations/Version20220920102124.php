<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920102124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creating user default';
    }

    public function up(Schema $schema): void
    {
        $users = [
            ['name' => 'jas.softwares@gmail.com', 'role'=> '[]', 'firstname'=>'Juan', 'lastname'=>'Alessandrini', 'password' => '$2y$13$S/hXjNEQwakDwxQCGQBTieIUnszC4ENNkF/p9/X74S/rjb32ZDIM6'],
            ['name'=>'leodascola@gmail.com', 'role'=>'[]', 'firstname'=>'Leonardo', 'lastname'=>'Dascola', 'password'=>'$2y$13$x1bZY2CJHUEUSQ6XzYxUhOTCZ0kCpta0KWMcw1h6zqXjijegyYjli']
        ];
    
        foreach ($users as $user) {
            
            $this->addSql("INSERT INTO `leoadmin`.`user` (`email`, `first_name`, `last_name`, `roles`, `password`) VALUES(:name, :firstname, :lastname, :role, :password )", $user);

            //$this->addSql("UPDATE `leoadmin`.`user` SET `roles` = '[ROLE_ADMIN' WHERE `email` = '".$user['name']."'");
        }
        

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
