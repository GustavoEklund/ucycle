<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20201016014122
 * @package Migrations
 */
final class Version20201016014122 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Users table creation';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE "user" (uuid UUID NOT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, active BOOLEAN DEFAULT \'true\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, full_name VARCHAR(128) NOT NULL, email VARCHAR(128) NOT NULL, password VARCHAR(72) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE INDEX IDX_8D93D649DE12AB56 ON "user" (created_by)');
        $this->addSql('CREATE INDEX IDX_8D93D64916FE72E1 ON "user" (updated_by)');
        $this->addSql('COMMENT ON COLUMN "user".uuid IS \'Uuidv4(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".created_by IS \'Uuidv4(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_by IS \'Uuidv4(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".active IS \'Define se o registro está ativo ou não\'');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'Data da criação deste registro\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'Data da última atualização neste registro\'');
        $this->addSql('COMMENT ON COLUMN "user".full_name IS \'Nome completo do usuário\'');
        $this->addSql('COMMENT ON COLUMN "user".email IS \'E-mail do usuário\'');
        $this->addSql('COMMENT ON COLUMN "user".password IS \'Senha do usuário em Hash Bcrypt\'');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64916FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649DE12AB56');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64916FE72E1');
        $this->addSql('DROP TABLE "user"');
    }
}
