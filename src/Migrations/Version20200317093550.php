<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200317093550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE impl_objectif DROP FOREIGN KEY FK_2F2774403A8E0A66');
        $this->addSql('ALTER TABLE impl_objectif DROP FOREIGN KEY FK_2F277440DC9DB291');
        $this->addSql('DROP INDEX IDX_2F2774403A8E0A66 ON impl_objectif');
        $this->addSql('DROP INDEX IDX_2F277440DC9DB291 ON impl_objectif');
        $this->addSql('ALTER TABLE impl_objectif DROP user_customer_id, DROP user_coach_id, DROP valide_customer, DROP valide_coach');
        $this->addSql('ALTER TABLE implementation ADD user_customer_id INT DEFAULT NULL, ADD user_coach_id INT DEFAULT NULL, ADD valide_customer TINYINT(1) DEFAULT NULL, ADD valide_coach TINYINT(1) DEFAULT NULL, ADD date_validate_coach DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE implementation ADD CONSTRAINT FK_C2DEEB5C3A8E0A66 FOREIGN KEY (user_customer_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE implementation ADD CONSTRAINT FK_C2DEEB5CDC9DB291 FOREIGN KEY (user_coach_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_C2DEEB5C3A8E0A66 ON implementation (user_customer_id)');
        $this->addSql('CREATE INDEX IDX_C2DEEB5CDC9DB291 ON implementation (user_coach_id)');
        $this->addSql('ALTER TABLE impl_avatar DROP FOREIGN KEY FK_61C8AA623A8E0A66');
        $this->addSql('ALTER TABLE impl_avatar DROP FOREIGN KEY FK_61C8AA62DC9DB291');
        $this->addSql('DROP INDEX IDX_61C8AA623A8E0A66 ON impl_avatar');
        $this->addSql('DROP INDEX IDX_61C8AA62DC9DB291 ON impl_avatar');
        $this->addSql('ALTER TABLE impl_avatar DROP user_customer_id, DROP user_coach_id, DROP valide_customer, DROP valide_coach');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE impl_avatar ADD user_customer_id INT DEFAULT NULL, ADD user_coach_id INT DEFAULT NULL, ADD valide_customer TINYINT(1) DEFAULT NULL, ADD valide_coach TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE impl_avatar ADD CONSTRAINT FK_61C8AA623A8E0A66 FOREIGN KEY (user_customer_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE impl_avatar ADD CONSTRAINT FK_61C8AA62DC9DB291 FOREIGN KEY (user_coach_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_61C8AA623A8E0A66 ON impl_avatar (user_customer_id)');
        $this->addSql('CREATE INDEX IDX_61C8AA62DC9DB291 ON impl_avatar (user_coach_id)');
        $this->addSql('ALTER TABLE impl_objectif ADD user_customer_id INT DEFAULT NULL, ADD user_coach_id INT DEFAULT NULL, ADD valide_customer TINYINT(1) DEFAULT NULL, ADD valide_coach TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE impl_objectif ADD CONSTRAINT FK_2F2774403A8E0A66 FOREIGN KEY (user_customer_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE impl_objectif ADD CONSTRAINT FK_2F277440DC9DB291 FOREIGN KEY (user_coach_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_2F2774403A8E0A66 ON impl_objectif (user_customer_id)');
        $this->addSql('CREATE INDEX IDX_2F277440DC9DB291 ON impl_objectif (user_coach_id)');
        $this->addSql('ALTER TABLE implementation DROP FOREIGN KEY FK_C2DEEB5C3A8E0A66');
        $this->addSql('ALTER TABLE implementation DROP FOREIGN KEY FK_C2DEEB5CDC9DB291');
        $this->addSql('DROP INDEX IDX_C2DEEB5C3A8E0A66 ON implementation');
        $this->addSql('DROP INDEX IDX_C2DEEB5CDC9DB291 ON implementation');
        $this->addSql('ALTER TABLE implementation DROP user_customer_id, DROP user_coach_id, DROP valide_customer, DROP valide_coach, DROP date_validate_coach');
    }
}
