<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Contract;

use BplUser\Contract\UserPasswordResetInterface;

interface UserPasswordResetMapperInterface {

    /**
     * Get password reset request record
     * 
     * @param string $requestKey
     * 
     * @return \BplUser\Contract\UserPasswordResetInterface
     */
    public function findByRequestKey($requestKey);

    /**
     * Remove request record with $requestKey
     * @param sting $requestKey
     */
    public function removeByRequestKey($requestKey);
    
    /**
     * Remove request record with $userId
     * @param int $userId
     */
    public function removeByUserId($userId);

    /**
     * Creates password request object for $user
     * @param UserPasswordResetInterface $request
     * @return UserPasswordResetInterface password reset request object
     */
    public function savePasswordResetRequestRecord(UserPasswordResetInterface $request);

    /**
     * Remove password reset requests which are older than $expireTime seconds
     * @param int $expireTime
     */
    public function removeOlderRequests(int $expireTime);

    /**
     * Get class name of the record
     */
    public function getClassName();
    
    /**
     * 
     * @return \BplUser\Contract\UserPasswordResetInterface
     */
    public function getEntity();
    
    /**
     * 
     * @param int $userId
     * @param string $token
     * @return \BplUser\Contract\UserPasswordResetInterface $resetRecord
     */
    public function getResetRecordByUserIdAndToken(string|int $userId, string $token);
    
}
