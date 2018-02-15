<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
interface ActivationMapperInterface {

    /**
     * 
     * @param int $userId
     * @param string $token
     * @return \BplUser\Provider\BplUserInterface $userRecord
     */
    public function getActivationRecordByUserIdToken(int $userId, string $token);

    /**
     * 
     * @param int $userId
     */
    public function clearActivationRecord(int $userId);
}
