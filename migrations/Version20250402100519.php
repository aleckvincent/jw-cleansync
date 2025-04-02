<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402100519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE assignment (id SERIAL NOT NULL, volunteer_id INT NOT NULL, team_id INT NOT NULL, confirmed BOOLEAN NOT NULL, day VARCHAR(3) DEFAULT NULL, activity VARCHAR(64) DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_30C544BA8EFAB6B1 ON assignment (volunteer_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_30C544BA296CD8AE ON assignment (team_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE team (id SERIAL NOT NULL, area VARCHAR(1) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA8EFAB6B1 FOREIGN KEY (volunteer_id) REFERENCES volunteer (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE assignment DROP CONSTRAINT FK_30C544BA8EFAB6B1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE assignment DROP CONSTRAINT FK_30C544BA296CD8AE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE assignment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE team
        SQL);
    }
}
