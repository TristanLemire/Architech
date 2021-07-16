<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716100039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, manager_id INT DEFAULT NULL, name VARCHAR(200) NOT NULL, phone VARCHAR(10) NOT NULL, city VARCHAR(50) NOT NULL, zipcode VARCHAR(5) NOT NULL, address VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_E16F61D4783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classroom (id INT AUTO_INCREMENT NOT NULL, building_id INT DEFAULT NULL, name VARCHAR(20) NOT NULL, floor INT NOT NULL, zone VARCHAR(10) NOT NULL, INDEX IDX_497D309D4D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manager (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, phone VARCHAR(10) NOT NULL, gender VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4783E3463 FOREIGN KEY (manager_id) REFERENCES manager (id)');
        $this->addSql('ALTER TABLE classroom ADD CONSTRAINT FK_497D309D4D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classroom DROP FOREIGN KEY FK_497D309D4D2A7E12');
        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D4783E3463');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE classroom');
        $this->addSql('DROP TABLE manager');
    }
}
