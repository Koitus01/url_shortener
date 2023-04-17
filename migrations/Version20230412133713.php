<?php

declare( strict_types=1 );

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230412133713 extends AbstractMigration
{
	public function getDescription(): string
	{
		return '';
	}

	public function up( Schema $schema ): void
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->addSql( 'CREATE TABLE link
							(
								id         INT AUTO_INCREMENT NOT NULL,
								url        LONGTEXT           NOT NULL,
								hash       VARCHAR(255)       NOT NULL,
								created_at DATETIME           NOT NULL default now() COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)
							) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB' );
		$this->addSql( 'CREATE TABLE link_stat 
							(
								id INT AUTO_INCREMENT NOT NULL, 
								link_id INT NOT NULL, visit_count 
									INT NOT NULL, UNIQUE INDEX UNIQ_91FF6D88ADA40271 (link_id), PRIMARY KEY(id)
							) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB' );
		$this->addSql( 'ALTER TABLE link_stat ADD CONSTRAINT FK_91FF6D88ADA40271 FOREIGN KEY (link_id) REFERENCES link (id)' );
	}

	public function down( Schema $schema ): void
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->addSql( 'ALTER TABLE link_stat DROP FOREIGN KEY FK_91FF6D88ADA40271' );
		$this->addSql( 'DROP TABLE link' );
		$this->addSql( 'DROP TABLE link_stat' );
	}
}
