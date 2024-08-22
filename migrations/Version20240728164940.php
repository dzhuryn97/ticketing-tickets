<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240728164940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id UUID NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, starts_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ends_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, canceled BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN event.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.starts_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN event.ends_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE ticket_type (id UUID NOT NULL, event_id UUID NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, currency VARCHAR(255) NOT NULL, quantity INT NOT NULL, available_quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN ticket_type.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN ticket_type.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE inbox_messages (inbox_message_id UUID NOT NULL, content TEXT NOT NULL, occurred_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, rejected_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, processed_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(inbox_message_id))');
        $this->addSql('COMMENT ON COLUMN inbox_messages.inbox_message_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inbox_messages.occurred_on IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN inbox_messages.delivered_on IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN inbox_messages.rejected_on IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN inbox_messages.processed_on IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE ticket_type');
        $this->addSql('DROP TABLE inbox_messages');
    }
}
