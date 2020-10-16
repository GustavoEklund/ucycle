<?php

namespace Domain\Entity;

use Application\Validation\DateTimeValidator;
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
    private DateTime $created_at;
    private DateTime $updated_at;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->active = true;
        $this->created_at = $this->updated_at = new DateTime;
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
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $date_time): _DefaultEntity
    {
        (new DateTimeValidator)->validate($date_time);
        $this->created_at = $date_time;
        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTime $date_time): _DefaultEntity
    {
        (new DateTimeValidator)->validate($date_time);
        $this->updated_at = $date_time;
        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return null;
    }
}