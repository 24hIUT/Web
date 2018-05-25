<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180525211422 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE event (id INTEGER NOT NULL, owner_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, date DATETIME NOT NULL, location VARCHAR(255) NOT NULL, random_string VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA77E3C61F9 ON event (owner_id)');
        $this->addSql('CREATE TABLE user (id INTEGER NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, e_mail VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, profile_picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_event (user_id INTEGER NOT NULL, event_id INTEGER NOT NULL, PRIMARY KEY(user_id, event_id))');
        $this->addSql('CREATE INDEX IDX_D96CF1FFA76ED395 ON user_event (user_id)');
        $this->addSql('CREATE INDEX IDX_D96CF1FF71F7E88B ON user_event (event_id)');
        $this->addSql('CREATE TABLE person (id INTEGER NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, profile_picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_event');
        $this->addSql('DROP TABLE person');
    }
}
