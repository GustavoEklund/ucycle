<?php

namespace Domain\Entity;

/**
 * Class User
 * @package Domain\Entity
 */
class User extends _DefaultEntity
{
    private string $full_name;

    public function getFullName(): ?string
    {
        return $this->full_name ?? null;
    }

    public function setFullName(string $full_name): User
    {
        $this->full_name = $full_name;
        return $this;
    }
}