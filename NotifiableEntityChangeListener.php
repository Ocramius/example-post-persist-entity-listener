<?php

namespace ExamplePostPersistEntityListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\PersistentCollection;

final class NotifiableEntityChangeListener implements EventSubscriber
{
    /**
     * @var NotifiableInterface[]
     */
    private $changedNotifiables = [];

    /**
     * @var NotificationServiceInterface
     */
    private $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
            Events::postFlush,
        ];
    }

    public function onFlush(OnFlushEventArgs $onFlush)
    {
        $this->changedNotifiables = [];

        $unitOfWork = $onFlush->getEntityManager()->getUnitOfWork();

        foreach (array_merge($unitOfWork->getScheduledEntityInsertions(), $unitOfWork->getScheduledEntityUpdates()) as $changedEntity) {
            if ($changedEntity instanceof NotifiableInterface) {
                $this->changedNotifiables[] = $changedEntity;
            }
        }

        /* @var $collection PersistentCollection */
        foreach (array_merge($unitOfWork->getScheduledCollectionDeletions(), $unitOfWork->getScheduledCollectionUpdates()) as $collection) {
            $changedEntity = $collection->getOwner();

            if ($changedEntity instanceof NotifiableInterface) {
                $this->changedNotifiables[] = $changedEntity;
            }
        }
    }

    public function postFlush()
    {
        try {
            array_map([$this->notificationService, 'notify'], $this->changedNotifiables);
        } finally {
            $this->changedNotifiables = [];
        }
    }
}
