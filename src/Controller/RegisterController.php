<?php

/**
 * Registration actions
 */

namespace BplUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use BplUser\Provider\BplUserInterface;
use BplUser\Provider\BplUserServiceInterface;
use BplUser\Provider\RegistrationOptionsInterface;

class RegisterController extends AbstractActionController {

    /**
     * @var \BplUser\Provider\BplUserServiceInterface
     */
    protected $bplUserService;

    /**
     * @var \BplUser\Provider\RegistrationOptionsInterface
     */
    protected $options;

    /**
     * @var \Zend\Form\Form
     */
    protected $registrationForm;

    /**
     * @var \BplUser\Provider\BplUserInterface
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
        if ($this->options->getRegistrationViewTemplate() !== '') {
            $vm->setTemplate($this->options->getRegistrationViewTemplate());
        }

        $user = false;
        $post = $this->getRequest()->getPost()->toArray();
        $this->registrationForm->bind($this->userEntity);
        $this->registrationForm->setData($post);
        
        if ($this->getRequest()->isPost() && $this->registrationForm->isValid()) {
            try {
                $user = $this->bplUserService->register($this->userEntity);
            } catch (\Exception $ex) {
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
            } catch (\Exception $ex) {
                $this->registrationForm->get('email')->setMessages([$ex->getMessage()]);
            }
        }

        if ($user !== false && $this->options->getLoginAfterRegistration() == false) {
            $this->auth()->clearIdentity();
        }

        /**
         * Logout if email verification is enabled
         */
        if ($user !== false && $this->options->getEnableEmailVerification()) {
            $this->auth()->clearIdentity();
            $this->bplUserService->sendRegistrationSuccessEmail($user);
            $vm->setVariable('user', $user);
            $vm->setVariable('emailVerification', true);
            $vm->setTemplate('bpl-user/registration-email-sent');
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
