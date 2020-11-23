<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20201123224411
 * @package Infrastructure\Doctrine\Migrations
 */
final class Version20201123224411 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'added verified and verify_code columns to users table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE users ADD verified BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE users ADD verify_code INT DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN users.verified IS \'Usuário verificado.\'');
        $this->addSql('COMMENT ON COLUMN users.verify_code IS \'Código de verificação do usuário. Usado para confirmar e-mail e redefinir a senha.\'');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users DROP verified');
        $this->addSql('ALTER TABLE users DROP verify_code');
    }
}
