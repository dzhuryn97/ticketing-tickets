<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240810093450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "ticket" (id UUID NOT NULL, customer_id UUID DEFAULT NULL, order_id UUID DEFAULT NULL, event_id UUID DEFAULT NULL, ticket_type_id UUID DEFAULT NULL, code VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, archived BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_97A0ADA39395C3F3 ON "ticket" (customer_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA38D9F6D38 ON "ticket" (order_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA371F7E88B ON "ticket" (event_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3C980D5C1 ON "ticket" (ticket_type_id)');
        $this->addSql('COMMENT ON COLUMN "ticket".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "ticket".customer_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "ticket".order_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "ticket".event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "ticket".ticket_type_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "ticket".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "ticket" ADD CONSTRAINT FK_97A0ADA39395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "ticket" ADD CONSTRAINT FK_97A0ADA38D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "ticket" ADD CONSTRAINT FK_97A0ADA371F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "ticket" ADD CONSTRAINT FK_97A0ADA3C980D5C1 FOREIGN KEY (ticket_type_id) REFERENCES ticket_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "ticket" DROP CONSTRAINT FK_97A0ADA39395C3F3');
        $this->addSql('ALTER TABLE "ticket" DROP CONSTRAINT FK_97A0ADA38D9F6D38');
        $this->addSql('ALTER TABLE "ticket" DROP CONSTRAINT FK_97A0ADA371F7E88B');
        $this->addSql('ALTER TABLE "ticket" DROP CONSTRAINT FK_97A0ADA3C980D5C1');
        $this->addSql('DROP TABLE "ticket"');
    }
}
