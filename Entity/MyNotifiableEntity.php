<?php

namespace ExamplePostPersistEntityListener\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ExamplePostPersistEntityListener\NotifiableInterface;

/**
 * @ORM\Entity
 */
class MyNotifiableEntity implements NotifiableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\ManyToMany(targetEntity=MyOtherEntity::class)
     */
    public $aCollection;

    /**
     * @ORM\Column(type="string")
     */
    public $aField = '';

    public function __construct()
    {
        $this->aCollection = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function getRecipients()
    {
        return ['foo@example.com'];
    }
}
