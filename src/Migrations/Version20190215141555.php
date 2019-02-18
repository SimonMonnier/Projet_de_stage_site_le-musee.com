<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215141555 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, introduction LONGTEXT NOT NULL, cover_image VARCHAR(255) NOT NULL, image1 VARCHAR(255) DEFAULT NULL, paragraphe1 LONGTEXT DEFAULT NULL, image2 VARCHAR(255) DEFAULT NULL, paragraphe2 LONGTEXT DEFAULT NULL, image3 VARCHAR(255) DEFAULT NULL, paragraphe3 LONGTEXT DEFAULT NULL, image4 VARCHAR(255) DEFAULT NULL, paragraphe4 LONGTEXT DEFAULT NULL, image5 VARCHAR(255) DEFAULT NULL, paragraphe5 LONGTEXT DEFAULT NULL, image6 VARCHAR(255) DEFAULT NULL, paragraphe6 LONGTEXT DEFAULT NULL, image7 VARCHAR(255) DEFAULT NULL, paragraphe7 LONGTEXT DEFAULT NULL, image8 VARCHAR(255) DEFAULT NULL, paragraphe8 LONGTEXT DEFAULT NULL, image9 VARCHAR(255) DEFAULT NULL, paragraphe9 LONGTEXT DEFAULT NULL, image10 VARCHAR(255) DEFAULT NULL, paragraphe10 LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE articles');
    }
}
