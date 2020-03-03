<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303083837 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE strategy_digital ADD lead_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE strategy_digital ADD CONSTRAINT FK_FD871EF755458D FOREIGN KEY (lead_id) REFERENCES customer_user (id)');
        $this->addSql('CREATE INDEX IDX_FD871EF755458D ON strategy_digital (lead_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE strategy_digital DROP FOREIGN KEY FK_FD871EF755458D');
        $this->addSql('DROP INDEX IDX_FD871EF755458D ON strategy_digital');
        $this->addSql('ALTER TABLE strategy_digital DROP lead_id');
    }
}
