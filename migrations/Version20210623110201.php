<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623110201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vegetable (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(125) NOT NULL, scientific_name VARCHAR(125) NOT NULL, family VARCHAR(125) NOT NULL, sowing_temperate_climates VARCHAR(125) DEFAULT NULL, sow_other_climates VARCHAR(125) DEFAULT NULL, plantation VARCHAR(125) DEFAULT NULL, harvest VARCHAR(125) DEFAULT NULL, flowerpot VARCHAR(125) DEFAULT NULL, substrate_fertilizer VARCHAR(125) DEFAULT NULL, irrigation VARCHAR(125) DEFAULT NULL, light VARCHAR(125) DEFAULT NULL, weather VARCHAR(125) DEFAULT NULL, difficulty VARCHAR(125) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, properties LONGTEXT DEFAULT NULL, associations LONGTEXT DEFAULT NULL, pests LONGTEXT DEFAULT NULL, filter_month VARCHAR(125) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vegetable');
    }
}
