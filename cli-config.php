<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

/** @var EntityManager $entity_manager */
$entity_manager = require(__DIR__ . '/bootstrap.php');

return ConsoleRunner::createHelperSet($entity_manager);
