<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200302212138 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE members_step (id INT AUTO_INCREMENT NOT NULL, step_strategy_id INT DEFAULT NULL, customer_user_id INT DEFAULT NULL, INDEX IDX_CD3DE99D41DC312 (step_strategy_id), INDEX IDX_CD3DE99BBB3772B (customer_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE members_step ADD CONSTRAINT FK_CD3DE99D41DC312 FOREIGN KEY (step_strategy_id) REFERENCES step_strategy (id)');
        $this->addSql('ALTER TABLE members_step ADD CONSTRAINT FK_CD3DE99BBB3772B FOREIGN KEY (customer_user_id) REFERENCES customer_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE members_step');
    }
}
