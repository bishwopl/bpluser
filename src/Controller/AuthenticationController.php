<?php

/**
 * Login and logout actions
 */

namespace BplUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use BplUser\Service\BplUserService;
use BplUser\Provider\AuthenticationControllerOptionsInterface;
use BplUser\Provider\BplUserServiceInterface;

class AuthenticationController extends AbstractActionController {

    /**
     * @var \BplUser\Provider\BplUserServiceInterface
     */
    protected $bplUserService;

    /**
     * @var \BplUser\Provider\AuthenticationControllerOptionsInterface
     */
    protected $options;

    /**
     * @var \Zend\Form\Form
     */
    protected $loginForm;
    protected $translator;

    /**
     * 
     * @param AuthenticationControllerOptionsInterface $options
     * @param BplUserService $bplUserService
     * @param Form $loginForm
     * @param type $translator
     */
    public function __construct(
    AuthenticationControllerOptionsInterface $options, BplUserServiceInterface $bplUserService, Form $loginForm, $translator) {
        $this->options = $options;
        $this->bplUserService = $bplUserService;
        $this->loginForm = $loginForm;
        $this->translator = $translator;
    }

    public function indexAction() {
        $vm = new ViewModel();
        $user = $this->auth()->getIdentity();
        $vm->setVariable('user', $user);
        return $vm;
    }

    public function loginAction() {
        $this->retrunIfLoggedIn();
        $user = NULL;
        $vm = new ViewModel();
        if ($this->options->getLoginViewTemplate() !== '') {
            $vm->setTemplate($this->options->getLoginViewTemplate());
        }

        $post = $this->getRequest()->getPost()->toArray();
        $this->loginForm->setData($post);

        if ($this->request->isPost() && $this->loginForm->isValid()) {
            $identity = trim($post['identity']);
            $credential = $post['credential'];

            try {
                $user = $this->auth()->authenticate($identity, $credential);
                if ($user !== NULL && $this->options->getEnableUserState() && !in_array($user->getState(), $this->options->getAllowedLoginStates())
                ) {
                    return $this->forward()->dispatch(AuthenticationController::class, ['action' => 'logout']);
                }
            } catch (\Exception $ex) {
                
            }

            $this->retrunIfLoggedIn();
        }

        $this->embedRedirect();

        $vm->setVariables([
            'loginForm' => $this->loginForm,
            'enableRegistration' => $this->options->getEnableRegistration()
        ]);
        return $vm;
    }

    public function logoutAction() {
        $this->auth()->clearIdentity();
        $redirectUrl = $this->getLogOutUrl();
        return $this->redirect()->toUrl($redirectUrl);
    }

    /**
     * Redirects to default logged in route if user is logged in
     * If redirect parameter(must be url) is present 
     * and use_redirect_parameter_if_present is true 
     * then redirects to the url
     * @return type
     */
    protected function retrunIfLoggedIn() {
        $user = $this->auth()->getIdentity();
        $redirectUrl = $this->getLogInUrl();
        if ($user !== NULL) {
            return $this->redirect()->toUrl($redirectUrl);
        }
    }

    /**
     * Login redirect url is embedded in login form as element named redirect
     * @return string
     */
    protected function getLogInUrl(): string {
        $url = $this->url()->fromRoute($this->options->getLoginRedirectRoute());
        $post = $this->getRequest()->getPost();
        if (isset($post['redirect']) && $this->options->getUseRedirectParameterIfPresent() == true) {
            $url = (string) ($post['redirect']);
        }
        return $url;
    }

    /**
     * Logout redirect url is embedded in logout query 
     * eg. http://{domain}/bpl-user/logout?redirect={redirect-url}
     * @return string
     */
    protected function getLogOutUrl(): string {
        $url = $this->url()->fromRoute($this->options->getLogoutRedirectRoute());
        $get = $this->getRequest()->getQuery();
        if (isset($get['redirect']) && $this->options->getUseRedirectParameterIfPresent() == true) {
            $url = (string) ($get['redirect']);
        }
        return $url;
    }

    /**
     * If redirect parameter is preset in login url 
     * eg. http://{domain}/user/login?redirect={redirect url after login}
     * then the url is embedded in the login form so that login controller knows 
     * where to redirect upon successful authentication. Default login redirect 
     * is taken from module configuration if ?redirect=xxx is not present
     */
    protected function embedRedirect() {
        $url = $this->url()->fromRoute($this->options->getLoginRedirectRoute());
        $get = $this->getRequest()->getQuery();
        if (isset($get['redirect']) && filter_var($get['redirect'], FILTER_VALIDATE_URL) && $this->options->getUseRedirectParameterIfPresent() == true) {
            $url = $get['redirect'];
        }
        $this->loginForm->get('redirect')->setValue($url);
    }

}
