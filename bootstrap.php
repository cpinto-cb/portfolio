<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


require_once "vendor/autoload.php";

// Load entity configuration from PHP file annotations
// This is the most versatile mode, I advise using it!
// If you don't like it, Doctrine also supports YAML or XML
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/Model"), $isDevMode);

// Set up database connection data
$conn = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'dbname'   => 'runnable_doctrine',
    'user'     => 'root',
    'password' => 'root'
);

$entityManager = EntityManager::create($conn, $config);
