<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230412134009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
		$this->addSql('CREATE INDEX link_created_at_index ON link (created_at)');
		$this->addSql('CREATE UNIQUE INDEX link_hash_uindex ON link (hash)');
		$this->addSql('CREATE INDEX link_stat_visit_count_index ON link_stat (visit_count)');
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
		$this->addSql('DROP INDEX link_created_at_index ON link');
		$this->addSql('DROP INDEX link_hash_uindex ON link');
		$this->addSql('DROP INDEX link_stat_visit_count_index ON link_stat');
    }
}
