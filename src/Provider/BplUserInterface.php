<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Provider;

interface BplUserInterface extends \CirclicalUser\Provider\UserInterface {

    public function getState();
    
    public function removeRole(\CirclicalUser\Provider\RoleInterface $role);
    
    public function hasRole(\CirclicalUser\Provider\RoleInterface $role);
}
