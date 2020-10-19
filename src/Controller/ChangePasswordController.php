<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Form\Form;

class ChangePasswordController extends AbstractActionController {

    /**
     *
     * @var \Laminas\Form\Form 
     */
    protected $changePasswordForm;

    public function __construct(Form $changePasswordForm) {
        $this->changePasswordForm = $changePasswordForm;
    }

    public function changePasswordAction() {
        $vm = new ViewModel();
        $success = false;
        $passwordVerified = true;

        $user = $this->auth()->getIdentity();
        $data = $this->getRequest()->getPost()->toArray();
        $this->changePasswordForm->setData($data);
        $currentPassword = $this->changePasswordForm->get('current_password')->getValue();
        $newPassword = $this->changePasswordForm->get('new_password')->getValue();
        
        if($this->getRequest()->isPost() && !$this->bpluser()->verifyPassword($user, $currentPassword)){
            $this->changePasswordForm->setMessages(['current_password'=> ['Incorrect credential']]);
            $passwordVerified = false;
        }
        
        if ($this->getRequest()->isPost() 
            && $this->changePasswordForm->isValid()
            && $passwordVerified
        ) {
            try {
                $this->bpluser()->changePassword($user, $newPassword);
                $success = true;
            } catch (Exception $ex) {
                //$this->changePasswordForm->setMessages(['email' => 'Cannot change email.']);
            }
        }

        if ($success) {
            $this->auth()->authenticate($user->getEmail(), $newPassword);
            $this->redirect()->toRoute('bpl-user');
        }

        $vm->setVariable('changePasswordForm', $this->changePasswordForm);
        return $vm;
    }

}
