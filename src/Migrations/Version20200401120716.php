<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200401120716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE impl_offre ADD structure_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE impl_offre ADD CONSTRAINT FK_176E5D6EDF129DA8 FOREIGN KEY (structure_service_id) REFERENCES structure_offre_service (id)');
        $this->addSql('CREATE INDEX IDX_176E5D6EDF129DA8 ON impl_offre (structure_service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE impl_offre DROP FOREIGN KEY FK_176E5D6EDF129DA8');
        $this->addSql('DROP INDEX IDX_176E5D6EDF129DA8 ON impl_offre');
        $this->addSql('ALTER TABLE impl_offre DROP structure_service_id');
    }
}
