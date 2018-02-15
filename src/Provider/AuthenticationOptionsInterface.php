<?php

namespace BplUser\Provider;

interface AuthenticationOptionsInterface {

    /**
     * set login form timeout in seconds
     *
     * @param int $loginFormTimeout
     */
    public function setLoginFormTimeout($loginFormTimeout);

    /**
     * set login form timeout in seconds
     *
     * @param int $loginFormTimeout
     */
    public function getLoginFormTimeout();

    /**
     * Tells controllers whether to use user state in login or not
     * 
     * @param bool $flag
     */
    public function setEnableUserState($flag);

    /**
     * get flag to check whether to use user state or not
     */
    public function getEnableUserState();

    /**
     * If UserState us enabled; only user with valid states are allowed to login 
     * @param array $states
     */
    public function setAllowedLoginStates(Array $states);

    /**
     * get states of user valid for login
     * ignored if enableUserState is false
     */
    public function getAllowedLoginStates();

    /**
     * Set view template for login form
     * @param string $loginViewTemplate
     */
    public function setLoginViewTemplate($loginViewTemplate);

    /**
     * get template for login form
     */
    public function getLoginViewTemplate();

    /**
     * Set duration of inactivity (in seconds) after which user is 
     * logged out automatically
     * @param type $autoLogoutPeriod
     */
    public function setAutoLogoutPeriod($autoLogoutPeriod);

    /**
     * Get duration of inactivity (in seconds) after which user is 
     * logged out automatically
     */
    public function getAutoLogoutPeriod();
}
