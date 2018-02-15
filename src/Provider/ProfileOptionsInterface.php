<?php

namespace BplUser\Provider;

interface ProfileOptionsInterface {

    /**
     * Set form factory for user profile modification
     * @param string $changeProfileFormFactory
     */
    public function setChangeProfileFormFactory($changeProfileFormFactory);

    /**
     * Get form factory for user profile modification
     */
    public function getChangeProfileFormFactory();
    
    /**
     * Set view template for user profile modification
     * @param string $changeProfileViewTemplate
     */
    public function setChangeProfileViewTemplate($changeProfileViewTemplate);

    /**
     * Get view template for user profile modification
     */
    public function getChangeProfileViewTemplate();
}
