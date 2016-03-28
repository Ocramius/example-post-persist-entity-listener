<?php

namespace ExamplePostPersistEntityListener;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class MyNotifiableEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type=integer)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $aField;
}
