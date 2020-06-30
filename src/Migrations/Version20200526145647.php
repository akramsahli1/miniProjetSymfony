<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526145647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE circuit (id INT AUTO_INCREMENT NOT NULL, code_circuit VARCHAR(255) NOT NULL, des_circuit LONGTEXT DEFAULT NULL, duree_circuit INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destination (id INT AUTO_INCREMENT NOT NULL, code_dest VARCHAR(255) NOT NULL, des_dest LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etape_circuit (id INT AUTO_INCREMENT NOT NULL, code_ville_etape_id INT NOT NULL, code_circuit_etape_id INT NOT NULL, duree_etape INT DEFAULT NULL, ordre_etape INT DEFAULT NULL, INDEX IDX_484C507DC3548F59 (code_ville_etape_id), INDEX IDX_484C507D71827C11 (code_circuit_etape_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, code_dest_id INT NOT NULL, code_ville VARCHAR(255) NOT NULL, des_ville LONGTEXT DEFAULT NULL, INDEX IDX_43C3D9C34124DC0B (code_dest_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etape_circuit ADD CONSTRAINT FK_484C507DC3548F59 FOREIGN KEY (code_ville_etape_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE etape_circuit ADD CONSTRAINT FK_484C507D71827C11 FOREIGN KEY (code_circuit_etape_id) REFERENCES circuit (id)');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C34124DC0B FOREIGN KEY (code_dest_id) REFERENCES destination (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etape_circuit DROP FOREIGN KEY FK_484C507D71827C11');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C34124DC0B');
        $this->addSql('ALTER TABLE etape_circuit DROP FOREIGN KEY FK_484C507DC3548F59');
        $this->addSql('DROP TABLE circuit');
        $this->addSql('DROP TABLE destination');
        $this->addSql('DROP TABLE etape_circuit');
        $this->addSql('DROP TABLE ville');
    }
}
