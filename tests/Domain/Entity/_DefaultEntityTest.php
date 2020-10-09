<?php

namespace Domain\Entity;

use PHPUnit\Framework\TestCase;

/**
 * Class _DefaultEntityTest
 * @package Domain\Entity
 */
class _DefaultEntityTest extends TestCase
{
    private _DefaultEntity $sut;

    public function setUp(): void
    {
        $this->sut = new _DefaultEntity;
    }

    public function test_assert_entity_starts_with_uuid(): void
    {
        self::assertNotEmpty($this->sut->getUuid());
    }
}