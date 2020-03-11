<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200310193737 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE impl_default (id INT AUTO_INCREMENT NOT NULL, implementation_id INT DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_EB44822ADF06C7D2 (implementation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cible_avatar (id INT AUTO_INCREMENT NOT NULL, impl_avatar_id INT DEFAULT NULL, question VARCHAR(255) DEFAULT NULL, answer VARCHAR(255) DEFAULT NULL, INDEX IDX_8AE692DAEC45C4FE (impl_avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE strategy_digital (id INT AUTO_INCREMENT NOT NULL, create_by_id INT DEFAULT NULL, lead_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_FD871EF79E085865 (create_by_id), INDEX IDX_FD871EF755458D (lead_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE impl_avatar (id INT AUTO_INCREMENT NOT NULL, implementation_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_61C8AA62DF06C7D2 (implementation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE impl_planning (id INT AUTO_INCREMENT NOT NULL, implementation_id INT DEFAULT NULL, status TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_1946A3E7DF06C7D2 (implementation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_permission (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, permission VARCHAR(50) NOT NULL, allowed TINYINT(1) NOT NULL, INDEX IDX_6F7DF886D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE implementation (id INT AUTO_INCREMENT NOT NULL, step_strategy_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C2DEEB5CD41DC312 (step_strategy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step_strategy (id INT AUTO_INCREMENT NOT NULL, strategy_id INT DEFAULT NULL, step_id INT DEFAULT NULL, INDEX IDX_24434782D5CAD932 (strategy_id), INDEX IDX_2443478273B21E9C (step_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, is_coach TINYINT(1) NOT NULL, name VARCHAR(50) NOT NULL, value VARCHAR(255) DEFAULT NULL, visible TINYINT(1) DEFAULT \'0\' NOT NULL, registration_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_5D9F75A1F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_user (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, compte_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, value VARCHAR(255) DEFAULT NULL, visible TINYINT(1) DEFAULT \'0\' NOT NULL, registration_date DATETIME DEFAULT NULL, INDEX IDX_D902723EB03A8386 (created_by_id), UNIQUE INDEX UNIQ_D902723EF2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE members_step (id INT AUTO_INCREMENT NOT NULL, step_strategy_id INT DEFAULT NULL, customer_user_id INT DEFAULT NULL, INDEX IDX_CD3DE99D41DC312 (step_strategy_id), INDEX IDX_CD3DE99BBB3772B (customer_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, compte_id INT DEFAULT NULL, date_from DATE NOT NULL, date_to DATE DEFAULT NULL, company VARCHAR(50) DEFAULT NULL, address VARCHAR(50) DEFAULT NULL, telephone VARCHAR(50) DEFAULT NULL, name VARCHAR(50) NOT NULL, value VARCHAR(255) DEFAULT NULL, visible TINYINT(1) DEFAULT \'0\' NOT NULL, registration_date DATETIME DEFAULT NULL, INDEX IDX_81398E09B03A8386 (created_by_id), UNIQUE INDEX UNIQ_81398E09F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_employee (customer_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_715A368E9395C3F3 (customer_id), INDEX IDX_715A368E8C03F15C (employee_id), PRIMARY KEY(customer_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, impl_planning_id INT DEFAULT NULL, step_strategy_id INT DEFAULT NULL, date_begin DATE DEFAULT NULL, date_end DATE DEFAULT NULL, status TINYINT(1) DEFAULT NULL, INDEX IDX_D499BFF6D0790883 (impl_planning_id), INDEX IDX_D499BFF6D41DC312 (step_strategy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documentaire (id INT AUTO_INCREMENT NOT NULL, step_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_5BC8DA6873B21E9C (step_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', image_filename VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1483A5E9A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_1483A5E9C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE impl_objectif (id INT AUTO_INCREMENT NOT NULL, implementation_id INT DEFAULT NULL, offre VARCHAR(255) DEFAULT NULL, delai VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_2F277440DF06C7D2 (implementation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526C8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objectif (id INT AUTO_INCREMENT NOT NULL, impl_objectif_id INT DEFAULT NULL, quantite INT DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, INDEX IDX_E2F86851F8824146 (impl_objectif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE impl_default ADD CONSTRAINT FK_EB44822ADF06C7D2 FOREIGN KEY (implementation_id) REFERENCES implementation (id)');
        $this->addSql('ALTER TABLE cible_avatar ADD CONSTRAINT FK_8AE692DAEC45C4FE FOREIGN KEY (impl_avatar_id) REFERENCES impl_avatar (id)');
        $this->addSql('ALTER TABLE strategy_digital ADD CONSTRAINT FK_FD871EF79E085865 FOREIGN KEY (create_by_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE strategy_digital ADD CONSTRAINT FK_FD871EF755458D FOREIGN KEY (lead_id) REFERENCES customer_user (id)');
        $this->addSql('ALTER TABLE impl_avatar ADD CONSTRAINT FK_61C8AA62DF06C7D2 FOREIGN KEY (implementation_id) REFERENCES implementation (id)');
        $this->addSql('ALTER TABLE impl_planning ADD CONSTRAINT FK_1946A3E7DF06C7D2 FOREIGN KEY (implementation_id) REFERENCES implementation (id)');
        $this->addSql('ALTER TABLE role_permission ADD CONSTRAINT FK_6F7DF886D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE implementation ADD CONSTRAINT FK_C2DEEB5CD41DC312 FOREIGN KEY (step_strategy_id) REFERENCES step_strategy (id)');
        $this->addSql('ALTER TABLE step_strategy ADD CONSTRAINT FK_24434782D5CAD932 FOREIGN KEY (strategy_id) REFERENCES strategy_digital (id)');
        $this->addSql('ALTER TABLE step_strategy ADD CONSTRAINT FK_2443478273B21E9C FOREIGN KEY (step_id) REFERENCES step (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1F2C56620 FOREIGN KEY (compte_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE customer_user ADD CONSTRAINT FK_D902723EB03A8386 FOREIGN KEY (created_by_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE customer_user ADD CONSTRAINT FK_D902723EF2C56620 FOREIGN KEY (compte_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE members_step ADD CONSTRAINT FK_CD3DE99D41DC312 FOREIGN KEY (step_strategy_id) REFERENCES step_strategy (id)');
        $this->addSql('ALTER TABLE members_step ADD CONSTRAINT FK_CD3DE99BBB3772B FOREIGN KEY (customer_user_id) REFERENCES customer_user (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09B03A8386 FOREIGN KEY (created_by_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09F2C56620 FOREIGN KEY (compte_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE customer_employee ADD CONSTRAINT FK_715A368E9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_employee ADD CONSTRAINT FK_715A368E8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6D0790883 FOREIGN KEY (impl_planning_id) REFERENCES impl_planning (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6D41DC312 FOREIGN KEY (step_strategy_id) REFERENCES step_strategy (id)');
        $this->addSql('ALTER TABLE documentaire ADD CONSTRAINT FK_5BC8DA6873B21E9C FOREIGN KEY (step_id) REFERENCES step (id)');
        $this->addSql('ALTER TABLE impl_objectif ADD CONSTRAINT FK_2F277440DF06C7D2 FOREIGN KEY (implementation_id) REFERENCES implementation (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE objectif ADD CONSTRAINT FK_E2F86851F8824146 FOREIGN KEY (impl_objectif_id) REFERENCES impl_objectif (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE step_strategy DROP FOREIGN KEY FK_24434782D5CAD932');
        $this->addSql('ALTER TABLE cible_avatar DROP FOREIGN KEY FK_8AE692DAEC45C4FE');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6D0790883');
        $this->addSql('ALTER TABLE impl_default DROP FOREIGN KEY FK_EB44822ADF06C7D2');
        $this->addSql('ALTER TABLE impl_avatar DROP FOREIGN KEY FK_61C8AA62DF06C7D2');
        $this->addSql('ALTER TABLE impl_planning DROP FOREIGN KEY FK_1946A3E7DF06C7D2');
        $this->addSql('ALTER TABLE impl_objectif DROP FOREIGN KEY FK_2F277440DF06C7D2');
        $this->addSql('ALTER TABLE implementation DROP FOREIGN KEY FK_C2DEEB5CD41DC312');
        $this->addSql('ALTER TABLE members_step DROP FOREIGN KEY FK_CD3DE99D41DC312');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6D41DC312');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09B03A8386');
        $this->addSql('ALTER TABLE customer_employee DROP FOREIGN KEY FK_715A368E8C03F15C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8C03F15C');
        $this->addSql('ALTER TABLE strategy_digital DROP FOREIGN KEY FK_FD871EF755458D');
        $this->addSql('ALTER TABLE members_step DROP FOREIGN KEY FK_CD3DE99BBB3772B');
        $this->addSql('ALTER TABLE strategy_digital DROP FOREIGN KEY FK_FD871EF79E085865');
        $this->addSql('ALTER TABLE customer_user DROP FOREIGN KEY FK_D902723EB03A8386');
        $this->addSql('ALTER TABLE customer_employee DROP FOREIGN KEY FK_715A368E9395C3F3');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1F2C56620');
        $this->addSql('ALTER TABLE customer_user DROP FOREIGN KEY FK_D902723EF2C56620');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09F2C56620');
        $this->addSql('ALTER TABLE step_strategy DROP FOREIGN KEY FK_2443478273B21E9C');
        $this->addSql('ALTER TABLE documentaire DROP FOREIGN KEY FK_5BC8DA6873B21E9C');
        $this->addSql('ALTER TABLE objectif DROP FOREIGN KEY FK_E2F86851F8824146');
        $this->addSql('ALTER TABLE role_permission DROP FOREIGN KEY FK_6F7DF886D60322AC');
        $this->addSql('DROP TABLE impl_default');
        $this->addSql('DROP TABLE cible_avatar');
        $this->addSql('DROP TABLE strategy_digital');
        $this->addSql('DROP TABLE impl_avatar');
        $this->addSql('DROP TABLE impl_planning');
        $this->addSql('DROP TABLE role_permission');
        $this->addSql('DROP TABLE implementation');
        $this->addSql('DROP TABLE step_strategy');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE customer_user');
        $this->addSql('DROP TABLE members_step');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_employee');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE documentaire');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE step');
        $this->addSql('DROP TABLE impl_objectif');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE objectif');
    }
}
