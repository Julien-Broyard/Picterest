<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225221127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add a relationship between User and Pin.';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pin ADD author_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN pin.author_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE pin ADD CONSTRAINT FK_B5852DF3F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B5852DF3F675F31B ON pin (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pin DROP CONSTRAINT FK_B5852DF3F675F31B');
        $this->addSql('DROP INDEX IDX_B5852DF3F675F31B');
        $this->addSql('ALTER TABLE pin DROP author_id');
    }
}
