<?php

namespace Domain\UseCase\AuthenticationToken;

use Domain\Entity\AuthenticationToken;
use Domain\Exception\RequiredValueException;
use Domain\UseCase\UseCase;

/**
 * Class CreateAuthenticationToken
 * @package Domain\UseCase\AuthenticationToken
 */
class CreateAuthenticationToken extends UseCase
{
    public function execute(AuthenticationToken $auth_token): void
    {
        if ($auth_token->getSub() === null) {
            throw new RequiredValueException('Sujeito', 500);
        }

        if ($auth_token->getCreatedBy() === null) {
            throw new RequiredValueException('Criado por', 500);
        }
    }
}