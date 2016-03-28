<?php

namespace ExamplePostPersistEntityListener;

use Doctrine\ORM\EntityManagerInterface;
use ExamplePostPersistEntityListener\Entity\MyNotifiableEntity;
use ExamplePostPersistEntityListener\Entity\MyOtherEntity;

/* @var $entityManager EntityManagerInterface */
$entityManager = require __DIR__ . '/bootstrap.php';

$entity1 = new MyNotifiableEntity();
$entity2 = new MyNotifiableEntity();
$entity3 = new MyOtherEntity();

$entityManager->persist($entity1);
$entityManager->persist($entity2);
$entityManager->persist($entity3);

var_dump('Flush #1:');

$entityManager->flush();

var_dump('Flush #2:');

$entityManager->flush();
