<?php

namespace BplUser\Contract;

use BplUser\Contract\BplUserInterface;

interface BplUserServiceInterface {

    /**
     * Resister user 
     * @param BplUserInterface $user
     */
    public function register(BplUserInterface $user);

    /**
     * Add default roles for a user
     * @param BplUserInterface $user
     */
    public function addDefaultRoles(BplUserInterface $user);

    /**
     * Send new user a registration successful notification
     * @param BplUserInterface $user
     */
    public function sendRegistrationSuccessEmail(BplUserInterface $user);

    /**
     * Send password reset link
     * @param string $email
     */
    public function sendPasswordResetEmail(string $email);

    /**
     * 
     * @param int $userId
     * @param string $token
     * @return \BplUser\Contract\UserPasswordResetInterface $resetRecord
     */
    public function getResetRecord(string|int $userId, string $token);

    /**
     * Remove all user password reset requests
     * @param int $userId
     */
    public function removePreviousResetRequests(string|int $userId);

    /**
     * Delete all forgot password requests which are expired
     */
    public function cleanExpiredForgotRequests();
    
}
