<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131090643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE journee (id INT AUTO_INCREMENT NOT NULL, organisateur_id INT NOT NULL, date DATETIME NOT NULL, lieu VARCHAR(255) NOT NULL, nb_participants_max INT NOT NULL, INDEX IDX_DC179AEDD936B2FA (organisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE journee ADD CONSTRAINT FK_DC179AEDD936B2FA FOREIGN KEY (organisateur_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE journee DROP FOREIGN KEY FK_DC179AEDD936B2FA');
        $this->addSql('DROP TABLE journee');
    }
}
