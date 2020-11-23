<?php

require_once(__DIR__.'/vendor/autoload.php');

use Doctrine\{DBAL\Types\Type, ORM\EntityManager, ORM\ORMException, ORM\Tools\Setup};
use Dotenv\Dotenv;

// Variáveis de ambiente
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required([
	'PRODUCTION_MODE',
	'INTERNAL_FOLDER',
	'TOKEN_SECRET_KEY',
	'DB_DRIVER',
	'DB_HOST',
	'DB_PORT',
	'DB_NAME',
	'DB_USER',
	'DB_CHARSET',
    'EMAIL_HOST',
    'EMAIL_USER_NAME',
    'EMAIL_PASSWORD',
    'EMAIL_PORT',
    'EMAIL_FROM_NAME',
    'EMAIL_FROM_EMAIL',
])->notEmpty();
$dotenv->required('DB_PASSWORD');
$dotenv->required('PRODUCTION_MODE')->isInteger();
$dotenv->required('PRODUCTION_MODE')->allowedValues(['0', '1']);

$is_dev_mode = (bool) $_ENV['PRODUCTION_MODE'];
$proxy_dir = null;
$cache = null;
$use_simple_annotation_reader = false;

$config = Setup::createAnnotationMetadataConfiguration(
	[__DIR__ . '/src/Domain/Entity'],
	$is_dev_mode,
	$proxy_dir,
	$cache,
	$use_simple_annotation_reader,
);

$connection = [
	'dbname' => $_ENV['DB_NAME'],
	'user' => $_ENV['DB_USER'],
	'password' => $_ENV['DB_PASSWORD'],
	'host' => $_ENV['DB_HOST'],
	'driver' => $_ENV['DB_DRIVER'],
	'charset' => $_ENV['DB_CHARSET'],
];

try {
	if (!Type::hasType('uuid')) {
		Type::addType('uuid', Ramsey\Uuid\Doctrine\UuidType::class);
	}

	return $entity_manager = EntityManager::create($connection, $config);
} catch (ORMException $orm_exception) {
	echo "{\"error\":\"{$orm_exception->getMessage()}\",\"data\":null}";
	exit;
} catch (\Doctrine\DBAL\Exception $dbal_exception) {
    echo "{\"error\":\"{$dbal_exception->getMessage()}\",\"data\":null}";
    exit;
}
