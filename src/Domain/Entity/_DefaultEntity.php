<?php

namespace Domain\Entity;

use Application\Validation\DateTimeValidator;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class _DefaultEntity
 * @package Domain\Entity
 *
 * @ORM\MappedSuperclass()
 */
class _DefaultEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(
     *     name="uuid",
     *     type="uuid",
     *     unique=true,
     *     options={"comment":"Uuidv4"}
     * )
     */
    private UuidInterface $uuid;

    /**
     * @ORM\Column(
     *     name="active",
     *     type="boolean",
     *     nullable=false,
     *     options={
     *     	   "comment": "Define se o registro está ativo ou não",
     *     	   "default": true
     *	   }
     * )
     */
    private bool $active;

    /**
     * @ORM\Column(
     *     name="created_at",
     *     type="datetime",
     *     nullable=false,
     *     options={
     *     	   "comment": "Data da criação deste registro",
     * 		   "default": "CURRENT_TIMESTAMP"
     *     }
     * )
     */
    private DateTime $created_at;

    /**
     * @ORM\Column(
     *     name="updated_at",
     *     type="datetime",
     *     nullable=false,
     *     options={
     *         "comment": "Data da última atualização neste registro",
     *	       "default": "CURRENT_TIMESTAMP"
     *	   }
     * )
     */
    private DateTime $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(
     *     name="created_by",
     *     referencedColumnName="uuid",
     *     onDelete="CASCADE"
     * )
     */
    private User $created_by;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(
     *     name="updated_by",
     *     referencedColumnName="uuid",
     *     onDelete="CASCADE"
     * )
     */
    private User $updated_by;

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
        return $this->created_by ?? null;
    }

    public function setCreatedBy(User $user): _DefaultEntity
    {
        $this->created_by = $user;
        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by ?? null;
    }

    public function setUpdatedBy(User $user): _DefaultEntity
    {
        $this->updated_by = $user;
        return $this;
    }
}