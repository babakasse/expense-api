<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516004627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE expense_note_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE company (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE expense_note (id INT NOT NULL, company_id INT NOT NULL, commercial_id INT NOT NULL, note_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, amount DOUBLE PRECISION NOT NULL, note_type VARCHAR(255) NOT NULL, registration_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7B1AB476979B1AD6 ON expense_note (company_id)');
        $this->addSql('CREATE INDEX IDX_7B1AB4767854071C ON expense_note (commercial_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE expense_note ADD CONSTRAINT FK_7B1AB476979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expense_note ADD CONSTRAINT FK_7B1AB4767854071C FOREIGN KEY (commercial_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE company_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE expense_note_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE expense_note DROP CONSTRAINT FK_7B1AB476979B1AD6');
        $this->addSql('ALTER TABLE expense_note DROP CONSTRAINT FK_7B1AB4767854071C');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE expense_note');
        $this->addSql('DROP TABLE "user"');
    }
}
