<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

$paths = array(__DIR__ . '/src/Entity');
$isDevMode = true;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '12345678',
    'dbname'   => 'vladlink',
    'charset' => 'utf8mb4',
    'driverOptions' => array(
        1002 => 'SET NAMES utf8mb4'
    ),
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
