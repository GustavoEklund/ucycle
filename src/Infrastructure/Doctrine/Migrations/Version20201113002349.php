<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20201113002349
 * @package Infrastructure\Doctrine\Migrations
 */
final class Version20201113002349 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'added authentication_token table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(
            'CREATE TABLE authentication_tokens (
                uuid UUID NOT NULL,
                created_by UUID DEFAULT NULL,
                updated_by UUID DEFAULT NULL,
                sub UUID DEFAULT NULL,
                active BOOLEAN DEFAULT \'true\' NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                iss VARCHAR(128) NOT NULL,
                iat INT NOT NULL,
                exp INT NOT NULL,
                nbf INT NOT NULL,
                PRIMARY KEY(uuid)
            )'
        );
        $this->addSql('CREATE INDEX IDX_E3D92D28DE12AB56 ON authentication_tokens (created_by)');
        $this->addSql('CREATE INDEX IDX_E3D92D2816FE72E1 ON authentication_tokens (updated_by)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E3D92D28580282DC ON authentication_tokens (sub)');
        $this->addSql('COMMENT ON COLUMN authentication_tokens.uuid IS \'Uuidv4(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN authentication_tokens.created_by IS \'Uuidv4(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN authentication_tokens.updated_by IS \'Uuidv4(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN authentication_tokens.sub IS \'Uuidv4(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN authentication_tokens.active IS \'Define se o registro está ativo ou não\'');
        $this->addSql('COMMENT ON COLUMN authentication_tokens.created_at IS \'Data da criação deste registro\'');
        $this->addSql('COMMENT ON COLUMN authentication_tokens.updated_at IS \'Data da última atualização neste registro\'');
        $this->addSql('COMMENT ON COLUMN authentication_tokens.iss IS \'\'\'iss\'\' (emissor) identifica quem emitiu o JWT. O processamento desta reivindicação é geralmente específico do aplicativo. O valor \'\'iss\'\' é uma sequência que diferencia maiúsculas de minúsculas que contém um valor StringOrURI.\'');
        $this->addSql('COMMENT ON COLUMN authentication_tokens.iat IS \'\'\'iat\'\' (emitida em) identifica o horário em que a JWT foi emitida. Essa alegação pode ser usada para determinar a idade do JWT. Seu valor DEVE ser um número que contenha um valor NumericDate.\'');
        $this->addSql('COMMENT ON COLUMN authentication_tokens.exp IS \'\'\'exp\'\' (tempo de expiração) identifica o tempo de expiração no qual ou após o qual o JWT NÃO DEVE ser aceito para processamento. O processamento da \'\'exp\'\' exige que a data/hora atual DEVE ser anterior à data / hora de vencimento listada na reivindicação \'\'exp\'\'. Os implementadores PODEM prever uma pequena margem de manobra, geralmente não mais do que alguns minutos, para contabilizar a inclinação do relógio. Seu valor DEVE ser um número que contenha um valor NumericDate.\'');
        $this->addSql('COMMENT ON COLUMN authentication_tokens.nbf IS \'\'\'nbf\'\' (não antes) identifica a hora antes da qual o JWT NÃO PODE ser aceito para processamento. O processamento do \'\'nbf\'\' reivindicação requer que a data / hora atual DEVE ser posterior ou igual a a data / hora não anterior listada na declaração \'\'nbf\'\'. Implementadores PODEM fornecer uma pequena margem de manobra, geralmente não mais do que alguns minutos, para explicar a distorção do relógio. Seu valor DEVE ser um número contendo um Valor NumericDate. O uso desta reivindicação é OPCIONAL.\'');
        $this->addSql(
            'ALTER TABLE authentication_tokens
                ADD CONSTRAINT FK_E3D92D28DE12AB56
                    FOREIGN KEY (created_by) REFERENCES users (uuid)
                        ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE authentication_tokens
                ADD CONSTRAINT FK_E3D92D2816FE72E1
                    FOREIGN KEY (updated_by) REFERENCES users (uuid)
                        ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE authentication_tokens
                ADD CONSTRAINT FK_E3D92D28580282DC
                    FOREIGN KEY (sub) REFERENCES users (uuid)
                        ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE authentication_tokens');
    }
}
