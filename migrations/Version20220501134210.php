<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220501134210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE song_genre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE song_genre (id INT NOT NULL, song_id INT NOT NULL, genre_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4EF4A6BDA0BDB2F3 ON song_genre (song_id)');
        $this->addSql('CREATE INDEX IDX_4EF4A6BD4296D31F ON song_genre (genre_id)');
        $this->addSql('COMMENT ON COLUMN song_genre.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE song_genre ADD CONSTRAINT FK_4EF4A6BDA0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE song_genre ADD CONSTRAINT FK_4EF4A6BD4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE song_genre_id_seq CASCADE');
        $this->addSql('DROP TABLE song_genre');
    }
}
