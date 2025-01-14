<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250114053431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement_abonne DROP FOREIGN KEY FK_FB921EE02A4C4478');
        $this->addSql('ALTER TABLE paiement_abonne DROP FOREIGN KEY FK_FB921EE0C325A696');
        $this->addSql('DROP TABLE paiement_abonne');
        $this->addSql('ALTER TABLE paiement ADD abonne_id INT NOT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EC325A696 FOREIGN KEY (abonne_id) REFERENCES abonne (id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EC325A696 ON paiement (abonne_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paiement_abonne (paiement_id INT NOT NULL, abonne_id INT NOT NULL, INDEX IDX_FB921EE02A4C4478 (paiement_id), INDEX IDX_FB921EE0C325A696 (abonne_id), PRIMARY KEY(paiement_id, abonne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE paiement_abonne ADD CONSTRAINT FK_FB921EE02A4C4478 FOREIGN KEY (paiement_id) REFERENCES paiement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement_abonne ADD CONSTRAINT FK_FB921EE0C325A696 FOREIGN KEY (abonne_id) REFERENCES abonne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EC325A696');
        $this->addSql('DROP INDEX IDX_B1DC7A1EC325A696 ON paiement');
        $this->addSql('ALTER TABLE paiement DROP abonne_id');
    }
}
