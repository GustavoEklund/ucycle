<?php

namespace Domain\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Domain\Exception\RequiredValueException;
use RangeException;

/**
 * Class AuthenticationToken
 * @package Domain\Entity
 *
 * @ORM\Entity(repositoryClass="Domain\Repository\AuthenticationTokenRepository")
 * @ORM\Table(name="authentication_tokens")
 */
class AuthenticationToken extends _DefaultEntity
{
    /**
     * @ORM\Column(
     *     name="iss",
     *     type="string",
     *       length=128,
     *     nullable=false,
     *     options={"comment":"'iss' (emissor) identifica quem emitiu o JWT. O processamento desta reivindicação é geralmente específico do aplicativo. O valor 'iss' é uma sequência que diferencia maiúsculas de minúsculas que contém um valor StringOrURI."}
     * )
     */
    private string $iss;

    /**
     * @ORM\Column(
     *     name="iat",
     *     type="integer",
     *     nullable=false,
     *     options={"comment":"'iat' (emitida em) identifica o horário em que a JWT foi emitida. Essa alegação pode ser usada para determinar a idade do JWT. Seu valor DEVE ser um número que contenha um valor NumericDate."}
     * )
     */
    private int $iat;

    /**
     * @ORM\Column(
     *     name="exp",
     *     type="integer",
     *     nullable=false,
     *     options={"comment":"'exp' (tempo de expiração) identifica o tempo de expiração no qual ou após o qual o JWT NÃO DEVE ser aceito para processamento. O processamento da 'exp' exige que a data/hora atual DEVE ser anterior à data / hora de vencimento listada na reivindicação 'exp'. Os implementadores PODEM prever uma pequena margem de manobra, geralmente não mais do que alguns minutos, para contabilizar a inclinação do relógio. Seu valor DEVE ser um número que contenha um valor NumericDate."}
     * )
     */
    private int $exp;

    /**
     * @ORM\Column(
     *     name="nbf",
     *     type="integer",
     *     nullable=false,
     *     options={"comment":"'nbf' (não antes) identifica a hora antes da qual o JWT NÃO PODE ser aceito para processamento. O processamento do 'nbf' reivindicação requer que a data / hora atual DEVE ser posterior ou igual a a data / hora não anterior listada na declaração 'nbf'. Implementadores PODEM fornecer uma pequena margem de manobra, geralmente não mais do que alguns minutos, para explicar a distorção do relógio. Seu valor DEVE ser um número contendo um Valor NumericDate. O uso desta reivindicação é OPCIONAL."}
     * )
     */
    private int $nbf;

    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(
     *     name="sub",
     *     referencedColumnName="uuid",
     *     onDelete="CASCADE",
     * )
     */
    private User $sub;

    public function __construct()
    {
        parent::__construct();

        $http_host = rtrim(
            !empty($_SERVER['HTTP_HOST'])
                ? $_SERVER['HTTP_HOST']
                : 'api.ucycle.com',
            '/'
        );

        $request_uri = !empty($_SERVER['REQUEST_URI'])
            ? $_SERVER['REQUEST_URI']
            : '/authentication';

        @$this->setIss(
            (
                !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
                ? "https"
                : "http"
            )
            . "://{$http_host}{$request_uri}"
        );

        $now = (new DateTime('now'))->getTimestamp();
        $this->setIat($now);
        $this->setExp($now + (20 * 60));
        $this->setNbf($now);
    }

    /**
     * @return string
     */
    public function getIss(): string
    {
        return $this->iss;
    }

    /**
     * @param string $iss
     * @return AuthenticationToken
     * @throws RangeException
     */
    public function setIss(string $iss): AuthenticationToken
    {
        $this->iss = $iss;
        return $this;
    }

    public function getIat(): int
    {
        return $this->iat;
    }

    /**
     * @param int $iat
     * @return AuthenticationToken
     */
    public function setIat(int $iat): AuthenticationToken
    {
        if ($iat < (new DateTime('now'))->getTimestamp()) {
            throw new RangeException('[emitido em] deve ser maior ou igual a data atual.');
        }

        $this->iat = $iat;
        return $this;
    }

    public function getExp(): int
    {
        return $this->exp;
    }

    /**
     * @param int $exp
     * @return AuthenticationToken
     */
    public function setExp(int $exp): AuthenticationToken
    {
        $now_plus_20_minutes = (new DateTime('now'))->getTimestamp() + (20 * 60);

        if ($exp !== $now_plus_20_minutes) {
            throw new RangeException('[Expira em] deve ser exatamente 20 minutos depois de agora.');
        }

        $this->exp = $exp;
        return $this;
    }

    public function getNbf(): int
    {
        return $this->nbf;
    }

    /**
     * @param int $nbf
     * @return AuthenticationToken
     */
    public function setNbf(int $nbf): AuthenticationToken
    {
        if ($nbf < $this->getIat()) {
            throw new RangeException('\'nbf\' deve ser maior ou igual a \'iat\'', 500);
        }

        $this->nbf = $nbf;
        return $this;
    }

    public function getSub(): ?User
    {
        return $this->sub ?? null;
    }

    /**
     * @param User $sub
     * @return AuthenticationToken
     */
    public function setSub(User $sub): AuthenticationToken
    {
        $this->sub = $sub;
        return $this;
    }

    public function getToken(): array
    {
        if ($this->getSub() === null) {
            throw new RequiredValueException('[Sub] necessário para criação do token.', 500);
        }

        return [
            'iss' => $this->getIss(),
            'iat' => $this->getIat(),
            'exp' => $this->getExp(),
            'nbf' => $this->getNbf(),
            'sub' => $this->getSub()->getUuid(),
            'jti' => $this->getUuid()->toString(),
        ];
    }
}