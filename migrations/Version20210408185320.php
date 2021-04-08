<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408185320 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archive ADD filiere_id INT NOT NULL');
        $this->addSql('ALTER TABLE archive ADD CONSTRAINT FK_D5FC5D9C180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('CREATE INDEX IDX_D5FC5D9C180AA129 ON archive (filiere_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archive DROP FOREIGN KEY FK_D5FC5D9C180AA129');
        $this->addSql('DROP INDEX IDX_D5FC5D9C180AA129 ON archive');
        $this->addSql('ALTER TABLE archive DROP filiere_id');
    }
}
