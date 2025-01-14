<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250113151354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonne (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(200) NOT NULL, firstname VARCHAR(200) NOT NULL, fname VARCHAR(200) NOT NULL, lname VARCHAR(200) NOT NULL, tele VARCHAR(255) NOT NULL, datetime DATETIME NOT NULL, active_sub TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_76328BF0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneau (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, dispo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneau_user (creneau_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D98922147D0729A9 (creneau_id), INDEX IDX_D9892214A76ED395 (user_id), PRIMARY KEY(creneau_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, montant DOUBLE PRECISION NOT NULL, pay_date DATETIME NOT NULL, mode_pay VARCHAR(211) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement_abonne (paiement_id INT NOT NULL, abonne_id INT NOT NULL, INDEX IDX_FB921EE02A4C4478 (paiement_id), INDEX IDX_FB921EE0C325A696 (abonne_id), PRIMARY KEY(paiement_id, abonne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonne ADD CONSTRAINT FK_76328BF0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE creneau_user ADD CONSTRAINT FK_D98922147D0729A9 FOREIGN KEY (creneau_id) REFERENCES creneau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE creneau_user ADD CONSTRAINT FK_D9892214A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement_abonne ADD CONSTRAINT FK_FB921EE02A4C4478 FOREIGN KEY (paiement_id) REFERENCES paiement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement_abonne ADD CONSTRAINT FK_FB921EE0C325A696 FOREIGN KEY (abonne_id) REFERENCES abonne (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonne DROP FOREIGN KEY FK_76328BF0A76ED395');
        $this->addSql('ALTER TABLE creneau_user DROP FOREIGN KEY FK_D98922147D0729A9');
        $this->addSql('ALTER TABLE creneau_user DROP FOREIGN KEY FK_D9892214A76ED395');
        $this->addSql('ALTER TABLE paiement_abonne DROP FOREIGN KEY FK_FB921EE02A4C4478');
        $this->addSql('ALTER TABLE paiement_abonne DROP FOREIGN KEY FK_FB921EE0C325A696');
        $this->addSql('DROP TABLE abonne');
        $this->addSql('DROP TABLE creneau');
        $this->addSql('DROP TABLE creneau_user');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE paiement_abonne');
    }
}
