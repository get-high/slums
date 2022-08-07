<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220807185236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3AF34668989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spots (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, content LONGTEXT DEFAULT NULL, how_to_get LONGTEXT DEFAULT NULL, rating DOUBLE PRECISION DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, is_main TINYINT(1) DEFAULT 0 NOT NULL, views INT DEFAULT NULL, years VARCHAR(255) DEFAULT NULL, authors VARCHAR(255) DEFAULT NULL, published_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_D2BBDDF7989D9B62 (slug), INDEX IDX_D2BBDDF761220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spot_category (spot_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_DE0BD82F2DF1D37C (spot_id), INDEX IDX_DE0BD82F12469DE2 (category_id), PRIMARY KEY(spot_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, uid VARCHAR(255) NOT NULL, provider VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX UNIQ_UID_PROVIDER (uid, provider), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE spots ADD CONSTRAINT FK_D2BBDDF761220EA6 FOREIGN KEY (creator_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE spot_category ADD CONSTRAINT FK_DE0BD82F2DF1D37C FOREIGN KEY (spot_id) REFERENCES spots (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spot_category ADD CONSTRAINT FK_DE0BD82F12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spots DROP FOREIGN KEY FK_D2BBDDF761220EA6');
        $this->addSql('ALTER TABLE spot_category DROP FOREIGN KEY FK_DE0BD82F2DF1D37C');
        $this->addSql('ALTER TABLE spot_category DROP FOREIGN KEY FK_DE0BD82F12469DE2');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE spots');
        $this->addSql('DROP TABLE spot_category');
        $this->addSql('DROP TABLE users');
    }
}
