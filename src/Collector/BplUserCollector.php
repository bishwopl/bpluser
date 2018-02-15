<?php

namespace BplUser\Collector;

use Zend\Mvc\MvcEvent;
use ZendDeveloperTools\Collector\AbstractCollector;
use CirclicalUser\Provider\UserInterface;
/**
 * BplUser Data Collector.
 *
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */
class BplUserCollector extends AbstractCollector {

    /**
     *
     * @var UserInterface  
     */
    protected $user;
    
    public function __construct(UserInterface $user=NULL) {
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return \BplUser\Collector\BplUserCollector::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority() {
        return 10;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(MvcEvent $mvcEvent) {
        if (!isset($this->user)) {
            $this->user = NULL;
        }
    }

    /**
     * Get User data as array.
     *
     * @return array
     */
    public function getUserData() {
        return $this->user;
    }

}
