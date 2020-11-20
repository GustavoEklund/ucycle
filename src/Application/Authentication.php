<?php

namespace Application;

use Exception;
use RuntimeException;
use UnexpectedValueException;
use Ramsey\Uuid\Uuid;
use Doctrine\ORM\EntityManager;
use Domain\Entity\AuthenticationToken;
use Domain\UseCase\AuthenticationToken\{
    CreateAuthenticationToken,
    DeleteAuthenticationToken,
    FindAuthenticationTokenBy,
};
use Firebase\JWT\{
    JWT,
    ExpiredException,
    BeforeValidException,
    SignatureInvalidException,
};

/**
 * Class Authentication
 * @package Application
 */
class Authentication
{
    private AuthenticationToken $authentication_token;

    public function __construct(AuthenticationToken $authentication_token)
    {
        $this->authentication_token = $authentication_token;
    }

    /**
     * @param CreateAuthenticationToken $create_authentication_token
     * @param FindAuthenticationTokenBy $find_authentication_token_by
     * @param DeleteAuthenticationToken $delete_authentication_token
     * @return string
     * @throws Exception
     */
    public function createToken(
        CreateAuthenticationToken $create_authentication_token,
        FindAuthenticationTokenBy $find_authentication_token_by,
        DeleteAuthenticationToken $delete_authentication_token
    ): string
    {
        $authentication_token = $find_authentication_token_by->execute([
            'created_by' => $this->authentication_token->getSub()->getUuid()->toString(),
        ]);

        if (!empty($authentication_token)) {
            $delete_authentication_token->execute($authentication_token[0]);
            $delete_authentication_token->getEntityManager()->flush();
        }

        $this->authentication_token->setUuid(Uuid::uuid4());
        $create_authentication_token->execute($this->authentication_token);
        $create_authentication_token->getEntityManager()->flush();

        return JWT::encode($this->authentication_token->getToken(), $_ENV['TOKEN_SECRET_KEY'], 'HS256');
    }

    /**
     * @param string $token
     * @param EntityManager $entity_manager
     * @return AuthenticationToken
     * @throws SignatureInvalidException
     * @throws BeforeValidException
     * @throws ExpiredException
     * @throws UnexpectedValueException
     */
    public function validateToken(string $token, EntityManager $entity_manager): AuthenticationToken
    {
        try {
            $token_array = explode(' ', $token);

            if (count($token_array) < 2) {
                throw new RuntimeException('Token de autenticação inválido.', 401);
            }

            $token_object = JWT::decode($token_array[1], $_ENV['TOKEN_SECRET_KEY'], ['HS256']);
        } catch (SignatureInvalidException $exception) {
            throw new SignatureInvalidException('Token de autenticação inválido.', 403);
        } catch (BeforeValidException $exception) {
            throw new BeforeValidException('O token de autenticação está sendo usado antes da data de criação.', 403);
        } catch (ExpiredException $exception) {
            throw new ExpiredException('A sua sessão expirou.', 403);
        } catch (UnexpectedValueException $exception) {
            throw new UnexpectedValueException('Token de autenticação inválido.', 403);
        }

        $auth_token_repository = $entity_manager->getRepository(AuthenticationToken::class);
        $auth_token_list = $auth_token_repository->findBy(['uuid' => @$token_object->jti]);

        if (empty($auth_token_list)) {
            throw new RuntimeException('Token de autenticação inválido.', 401);
        }

        return $auth_token_list[0];
    }
}