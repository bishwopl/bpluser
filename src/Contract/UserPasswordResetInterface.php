<?php

namespace BplUser\Contract;
use BplUser\Contract\BplUserInterface;
use DateTimeInterface;

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
interface UserPasswordResetInterface {

    public function setUser(BplUserInterface $user);

    public function getUser() : BplUserInterface;

    public function setRequestKey(string $requestKey);

    public function getRequestKey();

    public function setRequestTime(DateTimeInterface $requestTime);

    public function getRequestTime();
}
