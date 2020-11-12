<?php

require_once('./vendor/autoload.php');

use Doctrine\ORM\EntityManager;
use Expr\{ExprBuilder, Router};

/** @var EntityManager $entity_manager */
$entity_manager = require(__DIR__ . '/bootstrap.php');

$expr_builder = (new ExprBuilder())
    ->setControllersNamespace('Infrastructure\\Expr\\Controllers\\')
    ->setPathToControllers(__DIR__ . '/src/Infrastructure/Expr/Controllers')
    ->setProductionMode(true)
    ->setResource($entity_manager);

$router = new Router($expr_builder);

try {
    $router->post('/authentication/register', 'AuthenticationController@register');
} catch (JsonException $json_exception) {
    echo '{"error":{"code":500,"message":"' . $json_exception->getMessage() . '"},"data":null}';
}
