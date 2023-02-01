<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131153624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participants (id INT AUTO_INCREMENT NOT NULL, journee_id INT NOT NULL, UNIQUE INDEX UNIQ_71697092CF066148 (journee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participants_user (participants_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_616DCAA6838709D5 (participants_id), INDEX IDX_616DCAA6A76ED395 (user_id), PRIMARY KEY(participants_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_71697092CF066148 FOREIGN KEY (journee_id) REFERENCES journee (id)');
        $this->addSql('ALTER TABLE participants_user ADD CONSTRAINT FK_616DCAA6838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participants_user ADD CONSTRAINT FK_616DCAA6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_71697092CF066148');
        $this->addSql('ALTER TABLE participants_user DROP FOREIGN KEY FK_616DCAA6838709D5');
        $this->addSql('ALTER TABLE participants_user DROP FOREIGN KEY FK_616DCAA6A76ED395');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE participants_user');
    }
}
