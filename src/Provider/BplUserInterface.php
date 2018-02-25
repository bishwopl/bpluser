<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Provider;

interface BplUserInterface extends \CirclicalUser\Provider\UserInterface {

    public function getState();
}
