<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215093250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, voiture_id INT NOT NULL, caption VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_C53D045F181A8BA (voiture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, introduction LONGTEXT NOT NULL, content LONGTEXT NOT NULL, cover_image VARCHAR(255) NOT NULL, modele VARCHAR(255) NOT NULL, annee INT NOT NULL, create_at DATETIME NOT NULL, type VARCHAR(255) DEFAULT NULL, numero_serie VARCHAR(255) DEFAULT NULL, longueur VARCHAR(255) DEFAULT NULL, largeur VARCHAR(255) DEFAULT NULL, hauteur VARCHAR(255) DEFAULT NULL, poids_avide VARCHAR(255) DEFAULT NULL, carburant VARCHAR(255) NOT NULL, kilometrage VARCHAR(255) DEFAULT NULL, couleur_carrosserie VARCHAR(255) DEFAULT NULL, couleur_interieur VARCHAR(255) DEFAULT NULL, puissance VARCHAR(255) DEFAULT NULL, origine VARCHAR(255) DEFAULT NULL, boite_de_vitesse VARCHAR(255) DEFAULT NULL, moteur_et_cylindree VARCHAR(255) DEFAULT NULL, cv_fiscaux VARCHAR(255) DEFAULT NULL, conduite VARCHAR(255) DEFAULT NULL, nombre_de_place VARCHAR(255) DEFAULT NULL, carrosserie VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F181A8BA');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE voiture');
    }
}
