<?php

namespace ExamplePostPersistEntityListener;

interface NotifiableInterface
{
    /**
     * @return string[]
     */
    public function getRecipients();
}
