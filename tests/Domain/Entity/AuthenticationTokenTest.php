<?php

namespace Tests\Domain\Entity;

use DateTime;
use Domain\Entity\AuthenticationToken;
use Domain\Entity\User;
use Domain\Exception\RequiredValueException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use RangeException;

/**
 * Class AuthenticationTokenTest
 * @package Domain\Entities
 */
class AuthenticationTokenTest extends TestCase
{
    protected AuthenticationToken $sut;
    protected User $user;
    protected string $full_server_url;

    public function assertPreConditions(): void
    {
        self::assertNotEmpty($_SERVER['HTTPS']);
        self::assertNotEmpty($_SERVER['HTTP_HOST']);
        self::assertNotEmpty($_SERVER['REQUEST_URI']);
    }

    public function setUp(): void
    {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['HTTP_HOST'] = 'api.ucycle.com';
        $_SERVER['REQUEST_URI'] = '/authentication';

        $this->sut = new AuthenticationToken;
        $this->full_server_url = 'https://api.ucycle.com/authentication';

        $this->user = new User;
    }

    public function teste_assert_token_starts_with_issued_set(): void
    {
        // Arrange, Act, Assert
        self::assertEquals($this->full_server_url, $this->sut->getIss());
    }

    public function test_assert_can_start_token_with_issuer_even_without_server_http_host(): void
    {
        /**
         * If a globalized variable is unset() inside of a function, only the local variable is destroyed.
         * The variable in the calling environment will retain the same value as before unset() was called.
         *
         * This means that $_SERVER['HTTP_HOST'] still having the values set on self::setUp(), and it's not
         * a valid test, just using for semantic.
         *
         * Arrange
         */
        unset($_SERVER['HTTP_HOST']);

        // Act, Assert
        self::assertEquals($this->full_server_url, $this->sut->getIss());
    }

    public function test_assert_can_start_token_with_issuer_even_without_server_request_uri(): void
    {
        // Arrange
        unset($_SERVER['REQUEST_URI']);

        // Act, Assert
        self::assertEquals($this->full_server_url, $this->sut->getIss());
    }

    public function test_assert_issuer_http_secure_of_sets_the_property_protocol(): void
    {
        $_SERVER['HTTPS'] = 'off';
        $_SERVER['HTTP_HOST'] = 'api.digital-bank.com';
        $_SERVER['REQUEST_URI'] = '/authentication';

        $sut = new AuthenticationToken;

        self::assertEquals(
            'http://api.digital-bank.com/authentication',
            $sut->getIss()
        );
    }

    public function test_assert_token_starts_with_issued_at_set(): void
    {
        // Arrange, Act, Assert
        self::assertGreaterThan(
            1601468306,
            $this->sut->getIat()
        );
    }

    public function test_assert_that_set_issued_at_with_timestamp_less_than_now_throws_exception(): void
    {
        // Assert
        $this->expectException(RangeException::class);

        // Arrange, Act
        $this->sut->setIat(1601468306);
    }

    public function test_assert_token_starts_with_expire_at_set(): void
    {
        // Arrange
        $now_plus_20_minutes = (new DateTime('now'))->getTimestamp() + (20 * 60);

        // Act, Assert
        self::assertEquals($now_plus_20_minutes, $this->sut->getExp());
    }

    public function test_assert_set_expire_at_different_than_20_minutes_after_now_throws_exception(): void
    {
        // Assert
        $this->expectException(RangeException::class);

        // Arrange, Act
        $this->sut->setExp(1601468306);
    }

    public function test_assert_starts_with_nbf_is_equals_to_created_at(): void
    {
        // Arrange
        $this->sut->setCreatedAt(new DateTime('now'));

        // Act, Assert
        self::assertEquals($this->sut->getNbf(), $this->sut->getCreatedAt()->getTimestamp());
    }

    public function test_can_set_nbf(): void
    {
        // Arrange
        $now = (new DateTime('now'))->getTimestamp() + 100;

        // Act
        $this->sut->setNbf($now);

        // Assert
        self::assertEquals($now, $this->sut->getNbf());
    }

    public function test_assert_set_nbf_less_than_iat_throws_exception(): void
    {
        // Assert
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('\'nbf\' deve ser maior ou igual a \'iat\'');
        $this->expectExceptionCode(500);

        // Arrange, Act
        $this->sut->setNbf((new DateTime('now'))->getTimestamp() - 100);
    }

    public function test_assert_get_null_subject_if_not_set(): void
    {
        // Arrange, Act, Assert
        self::assertNull($this->sut->getSub());
    }

    public function test_can_set_subject(): void
    {
        // Arrange
        $user = $this->createMock(User::class);

        // Act
        /** @var User $user */
        $this->sut->setSub($user);

        // Assert
        self::assertInstanceOf(User::class, $this->sut->getSub());
    }

    public function test_get_token_without_subject_throws_exception(): void
    {
        // Assert
        $this->expectException(RequiredValueException::class);
        $this->expectExceptionMessage('[Sub] necessário para criação do token.');
        $this->expectExceptionCode(500);

        // Arrange, Act
        $this->sut->getToken();
    }

    public function test_assert_get_token_returns_expected_values(): void
    {
        $this->sut->setUuid(Uuid::uuid4());
        $this->sut->setSub($this->user);

        $expected_array = [
            'iss' => $this->sut->getIss(),
            'iat' => $this->sut->getIat(),
            'exp' => $this->sut->getExp(),
            'nbf' => $this->sut->getNbf(),
            'sub' => $this->sut->getSub()->getUuid(),
            'jti' => $this->sut->getUuid()->toString(),
        ];

        self::assertEquals($expected_array, $this->sut->getToken());
    }
}
