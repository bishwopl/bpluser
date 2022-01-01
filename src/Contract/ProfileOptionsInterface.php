<?php

namespace BplUser\Contract;

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
}
