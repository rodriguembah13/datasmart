<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200302094439 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planning_strategy ADD step_strategy_id INT DEFAULT NULL, ADD start_date DATE DEFAULT NULL, ADD end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE planning_strategy ADD CONSTRAINT FK_23431340D41DC312 FOREIGN KEY (step_strategy_id) REFERENCES step_strategy (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23431340D41DC312 ON planning_strategy (step_strategy_id)');
        $this->addSql('ALTER TABLE response ADD step_strategy_id INT DEFAULT NULL, ADD comment_id INT DEFAULT NULL, ADD name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFBD41DC312 FOREIGN KEY (step_strategy_id) REFERENCES step_strategy (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFBF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3E7B0BFBD41DC312 ON response (step_strategy_id)');
        $this->addSql('CREATE INDEX IDX_3E7B0BFBF8697D13 ON response (comment_id)');
        $this->addSql('ALTER TABLE step_strategy ADD strategy_id INT DEFAULT NULL, ADD step_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE step_strategy ADD CONSTRAINT FK_24434782D5CAD932 FOREIGN KEY (strategy_id) REFERENCES strategy_digital (id)');
        $this->addSql('ALTER TABLE step_strategy ADD CONSTRAINT FK_2443478273B21E9C FOREIGN KEY (step_id) REFERENCES step (id)');
        $this->addSql('CREATE INDEX IDX_24434782D5CAD932 ON step_strategy (strategy_id)');
        $this->addSql('CREATE INDEX IDX_2443478273B21E9C ON step_strategy (step_id)');
        $this->addSql('ALTER TABLE comment ADD employee_id INT DEFAULT NULL, ADD libelle VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('CREATE INDEX IDX_9474526C8C03F15C ON comment (employee_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE step_strategy DROP FOREIGN KEY FK_2443478273B21E9C');
        $this->addSql('DROP TABLE step');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8C03F15C');
        $this->addSql('DROP INDEX IDX_9474526C8C03F15C ON comment');
        $this->addSql('ALTER TABLE comment DROP employee_id, DROP libelle');
        $this->addSql('ALTER TABLE planning_strategy DROP FOREIGN KEY FK_23431340D41DC312');
        $this->addSql('DROP INDEX UNIQ_23431340D41DC312 ON planning_strategy');
        $this->addSql('ALTER TABLE planning_strategy DROP step_strategy_id, DROP start_date, DROP end_date');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFBD41DC312');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFBF8697D13');
        $this->addSql('DROP INDEX UNIQ_3E7B0BFBD41DC312 ON response');
        $this->addSql('DROP INDEX IDX_3E7B0BFBF8697D13 ON response');
        $this->addSql('ALTER TABLE response DROP step_strategy_id, DROP comment_id, DROP name');
        $this->addSql('ALTER TABLE step_strategy DROP FOREIGN KEY FK_24434782D5CAD932');
        $this->addSql('DROP INDEX IDX_24434782D5CAD932 ON step_strategy');
        $this->addSql('DROP INDEX IDX_2443478273B21E9C ON step_strategy');
        $this->addSql('ALTER TABLE step_strategy DROP strategy_id, DROP step_id');
    }
}
