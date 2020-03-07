<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200307085232 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE impl_avatar ADD implementation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE impl_avatar ADD CONSTRAINT FK_61C8AA62DF06C7D2 FOREIGN KEY (implementation_id) REFERENCES implementation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_61C8AA62DF06C7D2 ON impl_avatar (implementation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE impl_avatar DROP FOREIGN KEY FK_61C8AA62DF06C7D2');
        $this->addSql('DROP INDEX UNIQ_61C8AA62DF06C7D2 ON impl_avatar');
        $this->addSql('ALTER TABLE impl_avatar DROP implementation_id');
    }
}
