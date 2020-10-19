<?php
namespace BplUser\View\Helper;
use Laminas\View\Helper\AbstractHelper;

class GetBplUserIdentity extends AbstractHelper
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
        return $user;
    }
}