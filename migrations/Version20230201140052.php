<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201140052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE journee ADD organisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE journee ADD CONSTRAINT FK_DC179AEDD936B2FA FOREIGN KEY (organisateur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DC179AEDD936B2FA ON journee (organisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE journee DROP FOREIGN KEY FK_DC179AEDD936B2FA');
        $this->addSql('DROP INDEX IDX_DC179AEDD936B2FA ON journee');
        $this->addSql('ALTER TABLE journee DROP organisateur_id');
    }
}
