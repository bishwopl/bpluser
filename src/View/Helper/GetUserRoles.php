<?php
namespace BplUser\View\Helper;
use Laminas\View\Helper\AbstractHelper;

class GetUserRoles extends AbstractHelper
{
    /**
     *
     * @var \CirclicalUser\Service\AccessService 
     */
    protected $accessService;

    public function __construct($accessService) {
        $this->accessService = $accessService;
    }

    /**
     * 
     * @return array
     */
    public function __invoke()
    {
        return $this->accessService->getRoles();
    }
}

