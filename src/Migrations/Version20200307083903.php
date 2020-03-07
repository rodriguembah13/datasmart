<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200307083903 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE impl_default ADD implementation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE impl_default ADD CONSTRAINT FK_EB44822ADF06C7D2 FOREIGN KEY (implementation_id) REFERENCES implementation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB44822ADF06C7D2 ON impl_default (implementation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE impl_default DROP FOREIGN KEY FK_EB44822ADF06C7D2');
        $this->addSql('DROP INDEX UNIQ_EB44822ADF06C7D2 ON impl_default');
        $this->addSql('ALTER TABLE impl_default DROP implementation_id');
    }
}
