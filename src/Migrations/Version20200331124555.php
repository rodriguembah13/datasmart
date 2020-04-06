<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331124555 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE strategy_digital ADD is_offre_produit TINYINT(1) DEFAULT NULL, ADD is_offre_service TINYINT(1) DEFAULT NULL, ADD is_produit_unique TINYINT(1) DEFAULT NULL, ADD is_produit_collection TINYINT(1) DEFAULT NULL, ADD is_formation TINYINT(1) DEFAULT NULL, ADD is_coaching TINYINT(1) DEFAULT NULL, ADD is_consulting TINYINT(1) DEFAULT NULL, ADD is_prestation TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE strategy_digital DROP is_offre_produit, DROP is_offre_service, DROP is_produit_unique, DROP is_produit_collection, DROP is_formation, DROP is_coaching, DROP is_consulting, DROP is_prestation');
    }
}
