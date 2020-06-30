<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200616113942 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE circuit CHANGE duree_circuit duree_circuit INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etape_circuit CHANGE duree_etape duree_etape INT DEFAULT NULL, CHANGE ordre_etape ordre_etape INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ville ADD image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE circuit CHANGE duree_circuit duree_circuit INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etape_circuit CHANGE duree_etape duree_etape INT DEFAULT NULL, CHANGE ordre_etape ordre_etape INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ville DROP image');
    }
}
