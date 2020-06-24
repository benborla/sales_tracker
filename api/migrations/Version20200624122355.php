<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200624122355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'This migration will generate a default user upon installation';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
        INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`, `telephone`, `mobile`, `middle_name`, `address`, `city`, `state`, `country`, `zipcode`, `created_at`, `created_by_id`, `updated_by_id`, `updated_at`)
        VALUES
          (1, 'benborla@icloud.com', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '\$argon2i\$v=19\$m=65536,t=4,p=1\$QTVLRS96M29PQ0wvcXY4Lw\$rX9gpusWrEM+8WJE64aJyHGSQzNiLewOMsiuaGEPnOI', 'Ben', 'Borla', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NOW(), NULL, NULL, NOW());
        ");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
