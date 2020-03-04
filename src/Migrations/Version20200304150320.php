<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304150320 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE documentaire DROP FOREIGN KEY FK_5BC8DA68D41DC312');
        $this->addSql('DROP INDEX IDX_5BC8DA68D41DC312 ON documentaire');
        $this->addSql('ALTER TABLE documentaire CHANGE step_strategy_id step_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE documentaire ADD CONSTRAINT FK_5BC8DA6873B21E9C FOREIGN KEY (step_id) REFERENCES step (id)');
        $this->addSql('CREATE INDEX IDX_5BC8DA6873B21E9C ON documentaire (step_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE documentaire DROP FOREIGN KEY FK_5BC8DA6873B21E9C');
        $this->addSql('DROP INDEX IDX_5BC8DA6873B21E9C ON documentaire');
        $this->addSql('ALTER TABLE documentaire CHANGE step_id step_strategy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE documentaire ADD CONSTRAINT FK_5BC8DA68D41DC312 FOREIGN KEY (step_strategy_id) REFERENCES step_strategy (id)');
        $this->addSql('CREATE INDEX IDX_5BC8DA68D41DC312 ON documentaire (step_strategy_id)');
    }
}
