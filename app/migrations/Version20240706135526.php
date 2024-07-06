<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240706135526 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, due_date DATE NOT NULL, priority VARCHAR(255) NOT NULL COMMENT \'(DC2Type:task_priority)\', status VARCHAR(255) NOT NULL COMMENT \'(DC2Type:task_status)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5058659712469DE2 (category_id), INDEX IDX_50586597A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_5058659712469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_5058659712469DE2');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597A76ED395');
        $this->addSql('DROP TABLE tasks');
    }
}
