<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241215153729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client_credit (id SERIAL NOT NULL, client_id INT NOT NULL, product_name VARCHAR(100) NOT NULL, term INT NOT NULL, interest_rate DOUBLE PRECISION NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4967254D19EB6921 ON client_credit (client_id)');
        $this->addSql('ALTER TABLE client_credit ADD CONSTRAINT FK_4967254D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE client_credit DROP CONSTRAINT FK_4967254D19EB6921');
        $this->addSql('DROP TABLE client_credit');
    }
}
