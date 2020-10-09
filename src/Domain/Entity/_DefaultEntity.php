<?php

namespace Domain\Entity;

use DateTime;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class _DefaultEntity
 * @package Domain\Entity
 */
class _DefaultEntity
{
    private UuidInterface $uuid;
    private bool $active;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->active = true;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface $uuid): _DefaultEntity
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): _DefaultEntity
    {
        $this->active = $active;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return (new DateTime('now'));
    }
}