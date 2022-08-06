<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806141236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE spots (id INT AUTO_INCREMENT NOT NULL, published_by_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, content LONGTEXT DEFAULT NULL, how_to_get LONGTEXT DEFAULT NULL, rating DOUBLE PRECISION DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, is_main TINYINT(1) DEFAULT 0 NOT NULL, views INT DEFAULT NULL, years VARCHAR(255) DEFAULT NULL, authors VARCHAR(255) DEFAULT NULL, published_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D2BBDDF75B075477 (published_by_id), INDEX UNIQ_SLUG (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, uid VARCHAR(255) NOT NULL, provider VARCHAR(255) NOT NULL, is_admin TINYINT(1) DEFAULT 0 NOT NULL, last_login DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX UNIQ_UID_PROVIDER (uid, provider), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE spots ADD CONSTRAINT FK_D2BBDDF75B075477 FOREIGN KEY (published_by_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spots DROP FOREIGN KEY FK_D2BBDDF75B075477');
        $this->addSql('DROP TABLE spots');
        $this->addSql('DROP TABLE users');
    }
}
