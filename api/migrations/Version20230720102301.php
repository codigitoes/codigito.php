<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230720102301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blogcontents CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE youtube youtube VARCHAR(255) DEFAULT NULL, CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE blogposts CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE credentials CHANGE roles roles JSON NOT NULL, CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE fortunes CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE mailings CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE tags CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tags CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE blogcontents CHANGE image image VARCHAR(255) DEFAULT \'NULL\', CHANGE youtube youtube VARCHAR(255) DEFAULT \'NULL\', CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE mailings CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE fortunes CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE blogposts CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE credentials CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE created created DATETIME DEFAULT \'current_timestamp()\' NOT NULL, CHANGE updated updated DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
    }
}
