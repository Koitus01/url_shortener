<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230415113109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE link DROP INDEX link_hash_uindex, ADD INDEX link_hash_index (hash)');
        $this->addSql('ALTER TABLE link DROP scheme, DROP query_string');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE link DROP INDEX link_hash_index, ADD UNIQUE INDEX link_hash_uindex (hash)');
        $this->addSql('ALTER TABLE link ADD scheme VARCHAR(20) NOT NULL, ADD query_string LONGTEXT NOT NULL');
    }
}
