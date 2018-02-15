<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use CirclicalUser\Service\AuthenticationService;
use CirclicalUser\Provider\UserInterface;
use CirclicalUser\Mapper\AuthenticationMapper;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Service\AccessService;

class BplUserControllerPlugin extends AbstractPlugin {

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var \CirclicalUser\Service\AccessService
     */
    private $accessService;

    /**
     *
     * @var CirclicalUser\Mapper\AuthenticationMapper 
     */
    private $authenticationMapper;
    
    /**
     *
     * @var CirclicalUser\Mapper\UserMapper 
     */
    private  $userMapper;

    /**
     * 
     * @param AuthenticationService $authenticationService
     * @param AuthenticationMapper $authenticationMapper
     * @param UserMapper $userMapper
     */
    public function __construct(
            AuthenticationService $authenticationService, 
            AccessService $accessService,
            AuthenticationMapper $authenticationMapper, 
            UserMapper $userMapper) {
        $this->authenticationService = $authenticationService;
        $this->accessService = $accessService;
        $this->authenticationMapper = $authenticationMapper;
        $this->userMapper = $userMapper;
    }

    /**
     * 
     * @param UserInterface $user
     * @param type $newPassword
     */
    public function changePassword(UserInterface $user, $newPassword) {
        $this->authenticationService->resetPassword($user, $newPassword);
    }

    /**
     * 
     * @param UserInterface $user
     * @param type $newEmail
     * @return UserInterface
     */
    public function changeEmail(UserInterface $user, $newEmail) {
        $this->authenticationService->changeUsername($user, $newEmail);
        $user->setEmail($newEmail);
        $this->userMapper->update($user);
        return $user;
    }

    /**
     * 
     * @param type $email
     * @return bool
     */
    public function isEmailInUse($email){
        return $this->userMapper->findByEmail($email)!==NULL;
    }

    /**
     * 
     * @param UserInterface $user
     * @param type $password
     * @return bool
     */
    public function verifyPassword(UserInterface $user, $password) {
        $auth = $this->authenticationMapper->findByUsername($user->getEmail());
        return password_verify($password, $auth->getHash());
    }
    
    /**
     * 
     * @param UserInterface $user
     * @return UserInterface
     */
    public function saveProfile(UserInterface $user){
        $this->userMapper->update($user);
        return $user;
    }
    
    public function isAllowedAction(string $controllerName, string $action): bool{
        return $this->accessService->canAccessAction($controllerName, $action);
    }
}
