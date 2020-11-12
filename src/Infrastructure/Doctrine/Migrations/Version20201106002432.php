<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20201106002432
 * @package Infrastructure\Doctrine\Migrations
 */
final class Version20201106002432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'added users table';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE users (
                uuid UUID NOT NULL,
                created_by UUID DEFAULT NULL,
                updated_by UUID DEFAULT NULL,
                active BOOLEAN DEFAULT \'true\' NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                full_name VARCHAR(128) NOT NULL,
                email VARCHAR(128) NOT NULL,
                password VARCHAR(72) NOT NULL,
                PRIMARY KEY(uuid)
            )'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE INDEX IDX_1483A5E9DE12AB56 ON users (created_by)');
        $this->addSql('CREATE INDEX IDX_1483A5E916FE72E1 ON users (updated_by)');
        $this->addSql('COMMENT ON COLUMN users.uuid IS \'Uuidv4(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.created_by IS \'Uuidv4(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.updated_by IS \'Uuidv4(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.active IS \'Define se o registro está ativo ou não\'');
        $this->addSql('COMMENT ON COLUMN users.created_at IS \'Data da criação deste registro\'');
        $this->addSql('COMMENT ON COLUMN users.updated_at IS \'Data da última atualização neste registro\'');
        $this->addSql('COMMENT ON COLUMN users.full_name IS \'Nome completo do usuário\'');
        $this->addSql('COMMENT ON COLUMN users.email IS \'E-mail do usuário\'');
        $this->addSql('COMMENT ON COLUMN users.password IS \'Senha do usuário em Hash Bcrypt\'');
        $this->addSql(
            'ALTER TABLE users
                    ADD CONSTRAINT FK_1483A5E9DE12AB56
                        FOREIGN KEY (created_by) REFERENCES users (uuid)
                            ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE users
                    ADD CONSTRAINT FK_1483A5E916FE72E1
                        FOREIGN KEY (updated_by) REFERENCES users (uuid)
                            ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E9DE12AB56');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E916FE72E1');
        $this->addSql('DROP TABLE users');
    }
}
