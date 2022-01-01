<?php

namespace BplUser\Contract;

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
interface UserPasswordResetInterface {

    public function setUser($user);

    public function getUser();

    public function setRequestKey($requestKey);

    public function getRequestKey();

    public function setRequestTime(\DateTime $requestTime);

    public function getRequestTime();
}
