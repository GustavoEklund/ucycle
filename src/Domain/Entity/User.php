<?php

namespace Domain\Entity;

use Application\Validation\EmailValidator;
use Application\Validation\FullNameValidator;
use RangeException;
use RuntimeException;

/**
 * Class User
 * @package Domain\Entity
 */
class User extends _DefaultEntity
{
    private string $full_name;
    private string $email;
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
        if (strlen($password) < 6) {
            throw new RangeException('A senha deve ter pelo menos 6 caracteres.');
        } // if

        $password_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        if ($password_hash === false || !password_verify($password, (string)$password_hash)) {
            // Exception not testable
            throw new RuntimeException('Erro ao processar a senha.');
        } // if

        /** @var string $password_hash */
        $this->password = $password_hash;
        return $this;
    }
}
