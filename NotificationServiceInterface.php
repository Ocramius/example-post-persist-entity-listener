<?php

namespace ExamplePostPersistEntityListener;

interface NotificationServiceInterface
{
    public function notify(NotifiableInterface $entity);
}
