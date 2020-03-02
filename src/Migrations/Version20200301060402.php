<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200301060402 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE role_permission (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, permission VARCHAR(50) NOT NULL, allowed TINYINT(1) NOT NULL, INDEX IDX_6F7DF886D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, is_coach TINYINT(1) NOT NULL, name VARCHAR(50) NOT NULL, value VARCHAR(255) DEFAULT NULL, visible TINYINT(1) DEFAULT \'0\' NOT NULL, registration_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_5D9F75A1F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_user (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, compte_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, value VARCHAR(255) DEFAULT NULL, visible TINYINT(1) DEFAULT \'0\' NOT NULL, registration_date DATETIME DEFAULT NULL, INDEX IDX_D902723EB03A8386 (created_by_id), UNIQUE INDEX UNIQ_D902723EF2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, compte_id INT DEFAULT NULL, date_from DATE NOT NULL, date_to DATE DEFAULT NULL, name VARCHAR(50) NOT NULL, value VARCHAR(255) DEFAULT NULL, visible TINYINT(1) DEFAULT \'0\' NOT NULL, registration_date DATETIME DEFAULT NULL, INDEX IDX_81398E09B03A8386 (created_by_id), UNIQUE INDEX UNIQ_81398E09F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', image_filename VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1483A5E9A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_1483A5E9C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_permission ADD CONSTRAINT FK_6F7DF886D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1F2C56620 FOREIGN KEY (compte_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE customer_user ADD CONSTRAINT FK_D902723EB03A8386 FOREIGN KEY (created_by_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE customer_user ADD CONSTRAINT FK_D902723EF2C56620 FOREIGN KEY (compte_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09B03A8386 FOREIGN KEY (created_by_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09F2C56620 FOREIGN KEY (compte_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09B03A8386');
        $this->addSql('ALTER TABLE customer_user DROP FOREIGN KEY FK_D902723EB03A8386');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1F2C56620');
        $this->addSql('ALTER TABLE customer_user DROP FOREIGN KEY FK_D902723EF2C56620');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09F2C56620');
        $this->addSql('ALTER TABLE role_permission DROP FOREIGN KEY FK_6F7DF886D60322AC');
        $this->addSql('DROP TABLE role_permission');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE customer_user');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE role');
    }
}
