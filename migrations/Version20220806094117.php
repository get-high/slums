<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806094117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD uid VARCHAR(255) DEFAULT NULL AFTER name, ADD provider VARCHAR(255) DEFAULT NULL AFTER uid, ADD last_login DATETIME DEFAULT NULL AFTER provider, ADD is_admin TINYINT(1) DEFAULT 0 AFTER last_login');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_UID_PROVIDER ON users (uid, provider)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_UID_PROVIDER ON users');
        $this->addSql('ALTER TABLE users DROP uid, DROP provider, DROP last_login, DROP is_admin');
    }
}
