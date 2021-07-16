<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716100436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE incident (id INT AUTO_INCREMENT NOT NULL, classroom_id INT DEFAULT NULL, title VARCHAR(50) NOT NULL, date DATETIME NOT NULL, type VARCHAR(50) NOT NULL, status VARCHAR(100) NOT NULL, INDEX IDX_3D03A11A6278D5A8 (classroom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor (id INT AUTO_INCREMENT NOT NULL, classroom_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, node_id INT NOT NULL, INDEX IDX_BC8617B06278D5A8 (classroom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A6278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B06278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE sensor');
    }
}
