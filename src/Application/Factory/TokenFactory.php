<?php

namespace Application\Factory;

use Doctrine\ORM\EntityManager;
use Exception;
use Application\Authentication;
use Domain\Entity\AuthenticationToken;
use Domain\UseCase\AuthenticationToken\{
    CreateAuthenticationToken,
    DeleteAuthenticationToken,
    FindAuthenticationTokenBy,
};

/**
 * Class TokenFactory
 * @package Application\Factory
 */
class TokenFactory
{
    /**
     * @param AuthenticationToken $auth_token
     * @param EntityManager $entity_manager
     * @return string
     * @throws Exception
     */
    public static function create(AuthenticationToken $auth_token, EntityManager $entity_manager): string
    {
        return (new Authentication($auth_token))->createToken(
            new CreateAuthenticationToken($entity_manager),
            new FindAuthenticationTokenBy($entity_manager),
            new DeleteAuthenticationToken($entity_manager)
        );
    }
}
