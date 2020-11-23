<?php

namespace Domain\Entity;

use Application\Validation\{
    EmailValidator,
    FullNameValidator,
    PasswordValidator,
    VerifyCodeValidator,
};
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * Class User
 * @package Domain\Entity
 *
 * @ORM\Entity(repositoryClass="Domain\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends _DefaultEntity
{
    /**
     * @ORM\Column(
     *     name="full_name",
     *     type="string",
     *     length=128,
     *     nullable=false,
     *     options={"comment":"Nome completo do usuário"}
     * )
     */
    private string $full_name;

    /**
     * @ORM\Column(
     *     name="email",
     *     type="string",
     *     length=128,
     *     unique=true,
     *     nullable=false,
     *     options={"comment":"E-mail do usuário"}
     * )
     */
    private string $email;

    /**
     * @ORM\Column(
     *     name="password",
     *     type="string",
     *     length=72,
     *     nullable=false,
     *     options={"comment":"Senha do usuário em Hash Bcrypt"}
     * )
     */
    private string $password;

    /**
     * @ORM\Column(
     *     name="verified",
     *     type="boolean",
     *     nullable=false,
     *     options={"comment":"Usuário verificado."}
     * )
     */
    private bool $verified;

    /**
     * @ORM\Column(
     *     name="verify_code",
     *     type="integer",
     *     nullable=true,
     *     options={"comment":"Código de verificação do usuário. Usado para confirmar e-mail e redefinir a senha."}
     * )
     */
    private int $verify_code;

    /** @throws Exception */
    public function __construct()
    {
        parent::__construct();
        $this->verified = false;
        $this->verify_code = random_int(100000, 999999);
    }

    public function getFullName(): ?string
    {
        return $this->full_name ?? null;
    }

    public function setFullName(string $full_name): User
    {
        $this->full_name = (new FullNameValidator())->validate($full_name);
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email ?? null;
    }

    public function setEmail(string $email): User
    {
        $this->email = (new EmailValidator)->validate($email);
        return $this;
    }

    public function isPasswordValid(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function setPassword(string $password): User
    {
        /** @var string $password_hash */
        $this->password = (new PasswordValidator)->validate($password);
        return $this;
    }

    public function getVerified(): bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): User
    {
        $this->verified = $verified;
        return $this;
    }

    public function getVerifyCode(): int
    {
        return $this->verify_code;
    }

    public function setVerifyCode(int $verify_code): User
    {
        $this->verify_code = (new VerifyCodeValidator)->validate($verify_code);
        return $this;
    }
}
