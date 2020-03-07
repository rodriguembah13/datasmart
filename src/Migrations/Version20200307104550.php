<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200307104550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE objectif ADD impl_objectif_id INT DEFAULT NULL, ADD libelle VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE objectif ADD CONSTRAINT FK_E2F86851F8824146 FOREIGN KEY (impl_objectif_id) REFERENCES objectif (id)');
        $this->addSql('CREATE INDEX IDX_E2F86851F8824146 ON objectif (impl_objectif_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE objectif DROP FOREIGN KEY FK_E2F86851F8824146');
        $this->addSql('DROP INDEX IDX_E2F86851F8824146 ON objectif');
        $this->addSql('ALTER TABLE objectif DROP impl_objectif_id, DROP libelle');
    }
}
