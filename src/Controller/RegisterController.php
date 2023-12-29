<?php

/**
 * Registration actions
 */

namespace BplUser\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Form\Form;
use BplUser\Contract\BplUserInterface;
use BplUser\Contract\BplUserServiceInterface;
use BplUser\Contract\RegistrationOptionsInterface;

class RegisterController extends AbstractActionController {

    /**
     * @var \BplUser\Contract\BplUserServiceInterface
     */
    protected $bplUserService;

    /**
     * @var \BplUser\Contract\RegistrationOptionsInterface
     */
    protected $options;

    /**
     * @var \Laminas\Form\Form
     */
    protected $registrationForm;

    /**
     * @var \BplUser\Contract\BplUserInterface
     */
    protected $userEntity;

    public function __construct(
    RegistrationOptionsInterface $options, BplUserServiceInterface $bplUserService, Form $registrationForm, BplUserInterface $userEntity) {
        $this->options = $options;
        $this->bplUserService = $bplUserService;
        $this->registrationForm = $registrationForm;
        $this->userEntity = $userEntity;
    }

    public function registerAction() {
        if (!$this->options->getEnableRegistration()) {
            return $this->redirect()->toRoute($this->options->getLoginRedirectRoute());
        }
        $identity = $this->auth()->getIdentity();
        if ($identity !== NULL) {
            return $this->redirect()->toRoute($this->options->getLoginRedirectRoute());
        }
        
        $vm = new ViewModel();

        $user = false;
        $failed = false;
        $post = $this->getRequest()->getPost()->toArray();
        $this->registrationForm->setData($post);
        $this->registrationForm->bind($this->userEntity);
        
        if ($this->getRequest()->isPost() && $this->registrationForm->isValid()) {
            try {
                $this->userEntity = $this->registrationForm->getObject();
                $user = $this->bplUserService->register($this->userEntity);
            } catch (\Exception $ex) {
                $failed = true;
                $this->registrationForm->get('email')->setMessages([$ex->getMessage()]);
            }
        }

        if ($user !== false) {
            try {
                /**
                 * This creates and authenticates user
                 */
                $password = $this->bplUserService->getRandomString();
                if (isset($post['password'])) {
                    $password = $post['password'];
                }

                $this->auth()->create($user, $user->getEmail(), $password);
                $this->bplUserService->addDefaultRoles($user);
                $user = $this->auth()->getIdentity();
            } catch (\Exception $ex) {
                $failed = true;
                $this->registrationForm->get('email')->setMessages([$ex->getMessage()]);
            }
        }

        if ($user !== false && $this->options->getLoginAfterRegistration() == false) {
            $this->auth()->clearIdentity();
        }
        
        if($failed){
            echo 'Failed';
            if(is_object($user)){
                echo 'Deleting user';
                $this->auth()->deleteUserRecord($user);
            }
        }

        /**
         * Logout if email verification is enabled
         */
        if ($user !== false && $this->options->getEnableEmailVerification()) {
            $this->auth()->clearIdentity();
            $this->bplUserService->sendRegistrationSuccessEmail($user);
            $vm->setVariable('user', $user);
            $vm->setVariable('emailVerification', true);
            $vm->setVariable('registered', true);
        }

        if ($user !== false && !$this->options->getEnableEmailVerification()) {
            return $this->redirect()->toRoute('bpl-user');
        }

        $vm->setVariables([
            'registerForm' => $this->registrationForm
        ]);
        return $vm;
    }

}
