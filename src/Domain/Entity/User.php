<?php

namespace Domain\Entity;

use Application\Validation\EmailValidator;
use Application\Validation\FullNameValidator;

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
        return true;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }
}
