<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240511212854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE image image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE parfum CHANGE image image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) NOT NULL, ADD lastnmae VARCHAR(255) NOT NULL, ADD telephone VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE parfum CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastnmae, DROP telephone, DROP adresse');
    }
}
