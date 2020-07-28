<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200727081130 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE channel (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, is_active TINYINT(1) NOT NULL, is_archived TINYINT(1) DEFAULT NULL, date_created DATETIME DEFAULT NULL, date_updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_A2F98E47B03A8386 (created_by_id), UNIQUE INDEX UNIQ_A2F98E47896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE channel_profile (id INT AUTO_INCREMENT NOT NULL, channel_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_3614950E72F5A1AA (channel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE channel_role (id INT AUTO_INCREMENT NOT NULL, channel_profile_id INT DEFAULT NULL, role_key VARCHAR(155) NOT NULL, role_name VARCHAR(100) NOT NULL, INDEX IDX_CB3D29147A33422E (channel_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE channel_profile ADD CONSTRAINT FK_3614950E72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id)');
        $this->addSql('ALTER TABLE channel_role ADD CONSTRAINT FK_CB3D29147A33422E FOREIGN KEY (channel_profile_id) REFERENCES channel_profile (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE channel_profile DROP FOREIGN KEY FK_3614950E72F5A1AA');
        $this->addSql('ALTER TABLE channel_role DROP FOREIGN KEY FK_CB3D29147A33422E');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE channel_profile');
        $this->addSql('DROP TABLE channel_role');
    }
}
