<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200310200928 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment ADD step_strategy_id INT DEFAULT NULL, ADD status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD41DC312 FOREIGN KEY (step_strategy_id) REFERENCES step_strategy (id)');
        $this->addSql('CREATE INDEX IDX_9474526CD41DC312 ON comment (step_strategy_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CD41DC312');
        $this->addSql('DROP INDEX IDX_9474526CD41DC312 ON comment');
        $this->addSql('ALTER TABLE comment DROP step_strategy_id, DROP status');
    }
}
