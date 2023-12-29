<?php

/**
 * Login and logout actions
 */

namespace BplUser\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Form\Form;
use BplUser\Contract\BplUserServiceInterface;
use BplUser\Contract\ForgotPasswordOptionsInterface;

class ForgotController extends AbstractActionController {

    /**
     * @var \BplUser\Contract\BplUserServiceInterface
     */
    protected $bplUserService;

    /**
     * @var \BplUser\Contract\ForgotPasswordOptionsInterface
     */
    protected $options;

    /**
     * @var \Laminas\Form\Form
     */
    protected $forgotPasswordForm;
    
    /**
     * @var \Laminas\Form\Form
     */
    protected $resetPasswordForm;

    /**
     *
     * @var type 
     */
    protected $translator;

    public function __construct(
    ForgotPasswordOptionsInterface $options, BplUserServiceInterface $bplUserService, Form $forgotPasswordForm, Form $resetPasswordForm,  $translator) {
        $this->options = $options;
        $this->bplUserService = $bplUserService;
        $this->forgotPasswordForm = $forgotPasswordForm;
        $this->resetPasswordForm = $resetPasswordForm;
        $this->translator = $translator;
    }

    public function forgotPasswordAction() {
        $data = $this->getRequest()->getPost()->toArray();
        $this->forgotPasswordForm->setData($data);
        $this->bplUserService->cleanExpiredForgotRequests();
        $vm = new ViewModel();
        $vm->setVariable('forgotPasswordForm', $this->forgotPasswordForm);
        
        if ($this->getRequest()->isPost() && $this->forgotPasswordForm->isValid()) {
            $email = $data['email'];
            $this->bplUserService->sendPasswordResetEmail($email);
            $vm->setVariable('sent',true);
        }
        return $vm;
    }

    public function resetPasswordAction() {
        $userId = $this->params()->fromRoute('userId', 0);
        $token = (string) $this->params()->fromRoute('token', '');
        $resetRecord = $this->bplUserService->getResetRecord($userId, $token);
        
        $vm = new ViewModel();
        
        if ($resetRecord == NULL || strlen($token)!==32) {
            return $this->redirect()->toRoute('bpl-user/forgot-password');
        }

        $data = $this->getRequest()->getPost()->toArray();
        $this->resetPasswordForm->setData($data);
        
        $vm->setVariables([
            'resetPasswordForm' => $this->resetPasswordForm,
            'resetRecord' => $resetRecord,
        ]);
        
        if($this->getRequest()->isPost() && $this->resetPasswordForm->isValid()){
            $user = $resetRecord->getUser();
            $this->bpluser()->changePassword($user, $this->resetPasswordForm->get('password')->getValue());
            $this->bplUserService->removePreviousResetRequests($user->getId());
            $vm->setVariable('user', $user);
            $vm->setVariable('changed',true);
        }
        
        return $vm;
    }

}
