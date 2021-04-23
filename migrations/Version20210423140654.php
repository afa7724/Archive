<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210423140654 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3180AA129');
        $this->addSql('DROP INDEX IDX_717E22E3180AA129 ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP filiere_id');
        $this->addSql('ALTER TABLE user ADD filiere_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649180AA129 ON user (filiere_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant ADD filiere_id INT NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('CREATE INDEX IDX_717E22E3180AA129 ON etudiant (filiere_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649180AA129');
        $this->addSql('DROP INDEX IDX_8D93D649180AA129 ON user');
        $this->addSql('ALTER TABLE user DROP filiere_id');
    }
}
