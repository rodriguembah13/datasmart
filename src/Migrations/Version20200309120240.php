<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200309120240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cible_avatar ADD impl_avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cible_avatar ADD CONSTRAINT FK_8AE692DAEC45C4FE FOREIGN KEY (impl_avatar_id) REFERENCES impl_avatar (id)');
        $this->addSql('CREATE INDEX IDX_8AE692DAEC45C4FE ON cible_avatar (impl_avatar_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cible_avatar DROP FOREIGN KEY FK_8AE692DAEC45C4FE');
        $this->addSql('DROP INDEX IDX_8AE692DAEC45C4FE ON cible_avatar');
        $this->addSql('ALTER TABLE cible_avatar DROP impl_avatar_id');
    }
}
