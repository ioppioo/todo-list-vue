<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220723223154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25224F3C61');
        $this->addSql('DROP INDEX IDX_527EDB25224F3C61 ON task');
        $this->addSql('ALTER TABLE task CHANGE task_list_id task_lists_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25DDE6A3D7 FOREIGN KEY (task_lists_id) REFERENCES task_list (id)');
        $this->addSql('CREATE INDEX IDX_527EDB25DDE6A3D7 ON task (task_lists_id)');
        $this->addSql('ALTER TABLE task_list ADD title VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25DDE6A3D7');
        $this->addSql('DROP INDEX IDX_527EDB25DDE6A3D7 ON task');
        $this->addSql('ALTER TABLE task CHANGE task_lists_id task_list_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25224F3C61 FOREIGN KEY (task_list_id) REFERENCES task_list (id)');
        $this->addSql('CREATE INDEX IDX_527EDB25224F3C61 ON task (task_list_id)');
        $this->addSql('ALTER TABLE task_list DROP title');
    }
}
