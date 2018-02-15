<?php
namespace BplUser\View\Helper;
use Zend\View\Helper\AbstractHelper;

class GetUserEmail extends AbstractHelper
{
    /**
     *
     * @var \CirclicalUser\Service\AuthenticationService 
     */
    protected $authenticationService;

    public function __construct($authenticationService) {
        $this->authenticationService = $authenticationService;
    }

    public function __invoke()
    {
        $user = $this->authenticationService->getIdentity();
        if($user instanceof \CirclicalUser\Provider\UserInterface){
            $email = $user->getEmail();
        }
        return $email;
    }
}