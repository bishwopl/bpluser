<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Mapper;

use Doctrine\ORM\EntityManager;
use BplUser\Provider\UserPasswordResetMapperInterface;
use BplUser\Provider\UserPasswordResetInterface;

class UserPasswordResetMapper implements UserPasswordResetMapperInterface {

    /**
     *
     * @var \Doctrine\ORM\EntityManager 
     */
    protected $entityManager;

    /**
     *
     * @var string
     */
    protected $entityName;

    public function __construct(EntityManager $entityManager, $entityName) {
        $this->entityManager = $entityManager;
        $this->entityName = $entityName;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassName() {
        return $this->entityName;
    }

    /**
     * 
     * @return \BplUser\Provider\UserPasswordResetInterface
     */
    public function getEntity() {
        return new $this->entityName;
    }

    /**
     * {@inheritDoc}
     */
    public function savePasswordResetRequestRecord(UserPasswordResetInterface $request) {
        $this->entityManager->persist($request);
        $this->entityManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function findByRequestKey($requestKey) {
        return $this->getEntityRepository
                        ->findOneBy(['requestKey' => $requestKey]);
    }

    /**
     * {@inheritDoc}
     */
    public function removeByRequestKey($requestKey) {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->delete()->from($this->entityName, 'u')->where($qb->expr()->eq('u.requestKey', '?1'));
        $qb->setParameter(1, $requestKey);
        $qb->getQuery()->execute();
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function removeByUserId($userId) {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->delete()->from($this->entityName, 'u')->where($qb->expr()->eq('u.user', '?1'));
        $qb->setParameter(1, $userId);
        $qb->getQuery()->execute();
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function removeOlderRequests(int $expireTime) {
        $now = new \DateTime((int)$expireTime . ' seconds ago');
        $qb = $this->entityManager->createQueryBuilder();
        $qb->delete()->from($this->entityName, 'u')->where($qb->expr()->lt('u.requestTime', '?1'));
        $qb->setParameter(1, $now);
        $qb->getQuery()->execute();
    }

    /**
     * {@inheritDoc}
     */
    public function getResetRecordByUseIdToken(int $userId, string $token) {  
        return $this->getEntityRepository()->findOneBy([
            'user'     => $userId,
            'requestKey' => $token
        ]);
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getEntityRepository() {
        return $this->entityManager->getRepository($this->entityName);
    }

}
