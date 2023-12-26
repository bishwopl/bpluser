<?php
namespace BplUser\View\Helper;
use Laminas\View\Helper\AbstractHelper;

class IsAllowed extends AbstractHelper
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
     * @param string $controllerName
     * @param string|array $actions
     * @return boolean
     */
    public function __invoke($controllerName, $actions)
    {
        try{
            $allowed = true;
            if(!is_array($actions)){
                $actions = [$actions];
            }
            foreach ($actions as $ac){
                $allowed = $allowed && $this->accessService->canAccessAction($controllerName, $ac);
            }
            return $allowed;
        } catch (\Exception $ex) {
            return false;
        }
    }
}