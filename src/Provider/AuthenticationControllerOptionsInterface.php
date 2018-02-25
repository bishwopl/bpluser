<?php

namespace BplUser\Provider;

interface AuthenticationControllerOptionsInterface extends AuthenticationOptionsInterface {

    /**
     * set use redirect parameter if present
     *
     * @param bool $useRedirectParameterIfPresent
     */
    public function setUseRedirectParameterIfPresent($useRedirectParameterIfPresent);

    /**
     * get use redirect parameter if present
     *
     * @return bool
     */
    public function getUseRedirectParameterIfPresent();

    /**
     * set route where user us redirected after successful login
     * @param string $loginRedirectRoute
     */
    public function setLoginRedirectRoute($loginRedirectRoute);

    /**
     * get route where user us redirected after successful login
     */
    public function getLoginRedirectRoute();

    /**
     * set route where user us redirected after user logs out
     * @param string $logoutRedirectRoute
     */
    public function setLogoutRedirectRoute($logoutRedirectRoute);

    /**
     * get route where user us redirected after user logs out
     */
    public function getLogoutRedirectRoute();
}
