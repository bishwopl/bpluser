<?php

namespace BplUser\Listener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\EventSubscriber;

/**
 * Because this module doesn't provide a user
 *
 * Class UserEntityListener
 * @package CirclicalUser\Listener
 */
class UserEntityListener implements EventSubscriber
{
    const DEFAULT_ENTITY = 'BplUser\Entity\User';

    private $userEntity;

    public function __construct($userEntity)
    {
        $this->userEntity = $userEntity;
    }

    public function getSubscribedEvents()
    {
        return ['loadClassMetadata'];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var \Doctrine\ORM\Mapping\ClassMetadata $classMetadata */
        $classMetadata = $eventArgs->getClassMetadata();

        switch ($classMetadata->getName()) {
            case 'BplUser\Entity\UserPasswordReset':
                $classMetadata->associationMappings['user']['targetEntity'] = $this->userEntity;
                break;
        }
    }
}