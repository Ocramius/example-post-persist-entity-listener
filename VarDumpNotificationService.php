<?php

namespace ExamplePostPersistEntityListener;

class VarDumpNotificationService implements NotificationServiceInterface
{
    public function notify(NotifiableInterface $entity)
    {
        var_dump([get_class($entity) => $entity->getRecipients()]);
    }
}
