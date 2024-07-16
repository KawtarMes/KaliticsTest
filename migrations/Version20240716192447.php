<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240716192447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clocking_project (id INT AUTO_INCREMENT NOT NULL, duration INT NOT NULL, clocking_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_29254587B6D103F (clocking_id), INDEX IDX_29254587166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE clocking_project ADD CONSTRAINT FK_29254587B6D103F FOREIGN KEY (clocking_id) REFERENCES clocking (id)');
        $this->addSql('ALTER TABLE clocking_project ADD CONSTRAINT FK_29254587166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clocking_project DROP FOREIGN KEY FK_29254587B6D103F');
        $this->addSql('ALTER TABLE clocking_project DROP FOREIGN KEY FK_29254587166D1F9C');
        $this->addSql('DROP TABLE clocking_project');
    }
}
