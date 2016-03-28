<?php

namespace ExamplePostPersistEntityListener;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class MyNotifiableEntity implements NotifiableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type=integer)
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

    /**
     * {@inheritDoc}
     */
    public function getRecipients()
    {
        return ['foo@example.com'];
    }
}
