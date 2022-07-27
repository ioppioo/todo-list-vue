<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220720102306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE board (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, task_list_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, is_done TINYINT(1) NOT NULL, INDEX IDX_527EDB25224F3C61 (task_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_list (id INT AUTO_INCREMENT NOT NULL, board_id INT NOT NULL, task VARCHAR(255) NOT NULL, task_done TINYINT(1) NOT NULL, INDEX IDX_377B6C63E7EC5785 (board_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25224F3C61 FOREIGN KEY (task_list_id) REFERENCES task_list (id)');
        $this->addSql('ALTER TABLE task_list ADD CONSTRAINT FK_377B6C63E7EC5785 FOREIGN KEY (board_id) REFERENCES board (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_list DROP FOREIGN KEY FK_377B6C63E7EC5785');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25224F3C61');
        $this->addSql('DROP TABLE board');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_list');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
    }
}
