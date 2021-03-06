<?php

namespace ExamplePostPersistEntityListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Proxy\ProxyFactory;
use Doctrine\ORM\Tools\SchemaTool;

require_once __DIR__ . '/vendor/autoload.php';

AnnotationRegistry::registerLoader('class_exists');

$configuration = new Configuration();

$configuration->setMetadataDriverImpl(new AnnotationDriver(new AnnotationReader(), [__DIR__ . '/Entity']));
$configuration->setProxyDir(sys_get_temp_dir() . '/' . uniqid('example', true));
$configuration->setProxyNamespace('ProxyExample');
$configuration->setAutoGenerateProxyClasses(ProxyFactory::AUTOGENERATE_EVAL);

$entityManager = EntityManager::create(
    [
        'driverClass' => Driver::class,
        'path'        => __DIR__ . '/test-db.sqlite',
    ],
    $configuration
);

$entityManager
    ->getEventManager()
    ->addEventSubscriber(new NotifiableEntityChangeListener(new VarDumpNotificationService()));

$schemaTool = new SchemaTool($entityManager);

$schemaTool->updateSchema($entityManager->getMetadataFactory()->getAllMetadata());

return $entityManager;
