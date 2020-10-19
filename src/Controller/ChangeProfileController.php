<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Form\Form;
use BplUser\Provider\BplUserInterface;
use BplUser\Provider\ProfileOptionsInterface;

class ChangeProfileController extends AbstractActionController {

    /**
     *
     * @var \BplUser\Provider\ProfileControllerOptionsInterface 
     */
    protected $options;

    /**
     *
     * @var \Laminas\Form\Form 
     */
    protected $changeProfileForm;

    /**
     *
     * @var \BplUser\Provider\BplUserInterface 
     */
    protected $userEntity;

    public function __construct(ProfileOptionsInterface $options, Form $changeProfileForm, BplUserInterface $userEntity) {
        $this->options = $options;
        $this->changeProfileForm = $changeProfileForm;
        $this->userEntity = $userEntity;
    }

    public function changeProfileAction() {
        $vm = new ViewModel();
        $profileChanged = false;

        $user = $this->auth()->getIdentity();
        $this->changeProfileForm->bind($user);
        $data = $this->getRequest()->getPost()->toArray();
        $this->changeProfileForm->setData($data);
        
        if ($this->getRequest()->isPost() && $this->changeProfileForm->isValid()) {
            $profileChanged = true;
            try {
                $this->bpluser()->saveProfile($user);
            } catch (Exception $ex) {
                
            }
        }

        $vm->setVariable('changeProfileForm', $this->changeProfileForm);
        $vm->setVariable('profileChanged', $profileChanged);
        return $vm;
    }

}
