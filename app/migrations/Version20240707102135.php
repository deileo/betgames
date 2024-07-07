<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240707102135 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE INDEX category_name_idx ON categories (name)');
        $this->addSql('CREATE INDEX task_priority_idx ON tasks (priority)');
        $this->addSql('CREATE INDEX task_status_idx ON tasks (status)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX category_name_idx ON categories');
        $this->addSql('DROP INDEX task_priority_idx ON tasks');
        $this->addSql('DROP INDEX task_status_idx ON tasks');
    }
}
