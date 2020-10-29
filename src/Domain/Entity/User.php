<?php

namespace Domain\Entity;

use Application\Validation\{
    EmailValidator,
    FullNameValidator,
    PasswordValidator,
};
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Domain\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="user")
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
}
