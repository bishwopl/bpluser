<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;

class ChangeEmailController extends AbstractActionController {

    /**
     *
     * @var \Zend\Form\Form 
     */
    protected $changeEmailForm;

    public function __construct(Form $changeEmailForm) {
        $this->changeEmailForm = $changeEmailForm;
    }

    public function changeEmailAction() {
        $vm = new ViewModel();
        $success = false;
        $passwordVerified = true;
        $emailAvailable = true;

        $user = $this->auth()->getIdentity();
        $data = $this->getRequest()->getPost()->toArray();
        $this->changeEmailForm->setData($data);

        $newEmail = $this->changeEmailForm->get('email')->getValue();
        $password = $this->changeEmailForm->get('password')->getValue();

        if($this->getRequest()->isPost() && !$this->bpluser()->verifyPassword($user, $password)){
            $this->changeEmailForm->get('password')->setMessages(['Incorrect credential']);
            $passwordVerified = false;
        }
        
        if($this->getRequest()->isPost() && $user->getEmail()!==$newEmail && $this->bpluser()->isEmailInUse($newEmail)){
            $this->changeEmailForm->get('email')->setMessages(['This email address is already in use']);
            $emailAvailable = false;
        }
        
        if ($this->getRequest()->isPost() 
            && $this->changeEmailForm->isValid()
            && $passwordVerified && $emailAvailable
        ) {
            try {
                $this->bpluser()->changeEmail($user, $newEmail);
                $success = true;
            } catch (Exception $ex) {
                //$this->changeEmailForm->setMessages(['email' => 'Cannot change email.']);
            }
        }

        if ($success) {
            $this->auth()->authenticate($newEmail, $password);
            $this->redirect()->toRoute('bpl-user');
        }

        $vm->setVariable('changeEmailForm', $this->changeEmailForm);
        return $vm;
    }

}
