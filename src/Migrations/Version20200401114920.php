<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200401114920 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE structure_offre_service (id INT AUTO_INCREMENT NOT NULL, theme_principal VARCHAR(255) DEFAULT NULL, breve_description VARCHAR(255) DEFAULT NULL, lien_video_presentation VARCHAR(255) DEFAULT NULL, texte_bouton_appel VARCHAR(255) DEFAULT NULL, objectifs VARCHAR(255) DEFAULT NULL, contenu VARCHAR(255) DEFAULT NULL, avantage_description VARCHAR(255) DEFAULT NULL, procedure_livraison VARCHAR(255) DEFAULT NULL, valeur_offre VARCHAR(255) DEFAULT NULL, valeurtotal VARCHAR(255) DEFAULT NULL, valeur_promotionelle VARCHAR(255) DEFAULT NULL, moyen_payement VARCHAR(255) DEFAULT NULL, duree_offre VARCHAR(255) DEFAULT NULL, upsell_dowsell VARCHAR(255) DEFAULT NULL, comparaison VARCHAR(255) DEFAULT NULL, lien_image VARCHAR(255) DEFAULT NULL, text_bref VARCHAR(255) DEFAULT NULL, marque_confiance VARCHAR(255) DEFAULT NULL, avis VARCHAR(255) DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, profil_prestataire VARCHAR(255) DEFAULT NULL, notification_vente VARCHAR(255) DEFAULT NULL, chiffrerassurant VARCHAR(255) DEFAULT NULL, bonus_dation VARCHAR(255) DEFAULT NULL, histoire_emouvante VARCHAR(255) DEFAULT NULL, jeux_question VARCHAR(255) DEFAULT NULL, condition_elegibilite VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE impl_offre (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE implementation ADD impl_offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE implementation ADD CONSTRAINT FK_C2DEEB5C81174C4B FOREIGN KEY (impl_offre_id) REFERENCES impl_offre (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C2DEEB5C81174C4B ON implementation (impl_offre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE implementation DROP FOREIGN KEY FK_C2DEEB5C81174C4B');
        $this->addSql('DROP TABLE structure_offre_service');
        $this->addSql('DROP TABLE impl_offre');
        $this->addSql('DROP INDEX UNIQ_C2DEEB5C81174C4B ON implementation');
        $this->addSql('ALTER TABLE implementation DROP impl_offre_id');
    }
}
