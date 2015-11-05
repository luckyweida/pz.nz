<?php
require_once __DIR__ . '/../config.php';
require_once CMS . 'vendor/autoload.php';
$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
$driverImpl = $config->newDefaultAnnotationDriver(array(
    CMS . "vendor/luckyweida/pz"
), false);
$config->setMetadataDriverImpl($driverImpl);
$config->setProxyDir(__DIR__ . '/../cache/Proxies');
$config->setProxyNamespace('Proxies');
$connectionOptions = array(
    'driver' => 'pdo_mysql',
    'host' => DB_HOST,
    'dbname' => DB_NAME,
    'user' => DB_USER,
    'password' => DB_PASS,
    'charset' => DB_CHAR
);
$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
$helpers = new Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

