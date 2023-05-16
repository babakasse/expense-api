<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * //Adding some values to the tables
 */
final class Version20230516153205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adding some values to the tables';
    }

    public function up(Schema $schema): void
    {
        
        $this->addSql('INSERT INTO company (id, name) VALUES (1, \'Company 1\')');
        $this->addSql('INSERT INTO company (id, name) VALUES (2, \'Company 2\')');

        $this->addSql("INSERT INTO \"user\" (id, username, password, first_name, last_name, email, date_of_birth) 
        VALUES (:id, :username, :password, :first_name, :last_name, :email, :date_of_birth)",
        [
            'id' => 1,
            'username' => 'johndoe',
            'password' => '$2y$10$8RUuNUwIZ4g5QVCVUu6VQuX8kg.Vq3NHO82Ls2ZiSyWuPtEtMIGkK', // Replace with hashed password
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'date_of_birth' => '1990-01-01',
        ]);
    
        $this->addSql("INSERT INTO expense_note (id, company_id, commercial_id, note_date, amount, note_type, registration_date) 
        VALUES (:id, :company_id, :commercial_id, :note_date, :amount, :note_type, :registration_date)",
        [
            'id' => 1,
            'company_id' => 1,
            'commercial_id' => 1,
            'note_date' => '2021-01-01',
            'amount' => 100,
            'note_type' => 'expense',
            'registration_date' => '2021-01-01',
        ]);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM expense_note WHERE id = 1');
        $this->addSql('DELETE FROM "user" WHERE id = 1');
        $this->addSql('DELETE FROM company WHERE id IN (1, 2)');
    }

}
