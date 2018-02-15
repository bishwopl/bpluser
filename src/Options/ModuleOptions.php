<?php

namespace BplUser\Options;

use Zend\Stdlib\AbstractOptions;
use BplUser\Provider\AuthenticationControllerOptionsInterface;
use BplUser\Provider\UserServiceOptionsInterface;

class ModuleOptions extends AbstractOptions implements
AuthenticationControllerOptionsInterface, UserServiceOptionsInterface {

    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    //Authentication options start

    /**
     * @var int
     */
    protected $loginFormTimeout = 300;

    /**
     * @var bool
     */
    protected $useRedirectParameterIfPresent = true;

    /**
     * @var string
     */
    protected $loginRedirectRoute = 'bpl-user';

    /**
     * @var string
     */
    protected $logoutRedirectRoute = 'bpl-user/login';

    /**
     * @var int
     */
    protected $enableUserState = false;

    /**
     * @var Array
     */
    protected $allowedLoginStates = [null, 1];

    /**
     * @var String
     */
    protected $loginViewTemplate = 'bpl-user/login-view-template';

    /**
     * Auto logout period in seconds
     * @var int 
     */
    protected $autoLogoutPeriod = 1800;
    //Authentication options end
    //Email options start

    /**
     * sender email address
     * @var string 
     */
    protected $emailFrom;

    /**
     * sender name
     * @var string 
     */
    protected $emailFromName;

    /**
     * reply to email address
     * @var string 
     */
    protected $replyTo;
    
    /**
     * @var bool 
     */
    protected $useSmtp;
    
    /**
     * Extra mailer options for smtp configuration
     * @var array 
     */
    protected $smtpOptions = [];
    
    /**
     * Mailer factory
     * @var type 
     */
    protected $mailerServiceFactory = \BplUser\Service\MailService::class;
    
    //Email options end
    //Forgot password options start
    /**
     * Password reset request expire time in seconds
     * @var int 
     */
    protected $resetExpire = 86400;

    /**
     * @var string 
     */
    protected $forgotPasswordEmailTemplate = 'bpl-user/forgot-password-email-template';

    /**
     *
     * @var string 
     */
    protected $forgotPasswordEmailSubjectLine = 'Password reset request';

    //Forgot password options end
    //Profile options start

    /**
     * @var type 
     */
    protected $changeProfileFormFactory = \BplUser\Form\ChangeProfile::class;
    
    /**
     * @var string 
     */
    protected $changeProfileViewTemplate = 'bpl-user/change-profile-view-template';


    //Profile options end
    //Registration options start

    /**
     * @var bool
     */
    protected $enableRegistration = true;

    /**
     * @var int
     */
    protected $userFormTimeout = 300;

    /**
     * @var bool 
     */
    protected $enableEmailVerification = false;

    /**
     * @var bool
     */
    protected $loginAfterRegistration = true;

    /**
     * @var bool
     */
    protected $useRegistrationFormCaptcha = false;

    /**
     * @var array
     */
    protected $formCaptchaOptions = [
        'class' => 'figlet',
        'width' => 200,
        'height' => 100,
        'expiration' => 600,
        'wordLen' => 2,
    ];

    /**
     * @var int
     */
    protected $defaultUserState = 1;

    /**
     * @var array
     */
    protected $defaultRoles = [];

    /**
     *
     * @var string 
     */
    protected $registrationFormFactory = \BplUser\Form\Factory\Register::class;

    /**
     *
     * @var string 
     */
    protected $registrationEmailSubjectLine = 'Welcome to my domain';

    /**
     *
     * @var string 
     */
    protected $registrationViewTemplate = 'bpl-user/registration-view-template';

    /**
     *
     * @var string 
     */
    protected $registrationEmailTemplate = 'bpl-user/registration-email-template';

    //Registration options end

    /**
     * {@inheritDoc}
     */
    public function setLoginFormTimeout($loginFormTimeout) {
        $this->loginFormTimeout = $loginFormTimeout;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLoginFormTimeout() {
        return $this->loginFormTimeout;
    }

    /**
     * {@inheritDoc}
     */
    public function setUseRedirectParameterIfPresent($useRedirectParameterIfPresent) {
        $this->useRedirectParameterIfPresent = $useRedirectParameterIfPresent;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUseRedirectParameterIfPresent() {
        return $this->useRedirectParameterIfPresent;
    }

    /**
     * {@inheritDoc}
     */
    public function setLoginRedirectRoute($loginRedirectRoute) {
        $this->loginRedirectRoute = $loginRedirectRoute;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLoginRedirectRoute() {
        return $this->loginRedirectRoute;
    }

    /**
     * {@inheritDoc}
     */
    public function setLogoutRedirectRoute($logoutRedirectRoute) {
        $this->logoutRedirectRoute = $logoutRedirectRoute;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLogoutRedirectRoute() {
        return $this->logoutRedirectRoute;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnableUserState() {
        return $this->enableUserState;
    }

    /**
     * {@inheritDoc}
     */
    public function setEnableUserState($flag) {
        $this->enableUserState = $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAllowedLoginStates() {
        return $this->allowedLoginStates;
    }

    /**
     * {@inheritDoc}
     */
    public function setAllowedLoginStates(Array $states) {
        $this->allowedLoginStates = $states;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setLoginViewTemplate($loginViewTemplate) {
        $this->loginViewTemplate = $loginViewTemplate;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLoginViewTemplate() {
        return $this->loginViewTemplate;
    }

    /**
     * {@inheritDoc}
     */
    public function setAutoLogoutPeriod($autoLogoutPeriod) {
        $this->autoLogoutPeriod = $autoLogoutPeriod;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoLogoutPeriod() {
        return $this->getAutoLogoutPeriod();
    }

    /**
     * {@inheritDoc}
     */
    public function setEmailFrom($emailFrom) {
        $this->emailFrom = $emailFrom;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEmailFrom() {
        return $this->emailFrom;
    }

    /**
     * {@inheritDoc}
     */
    public function setEmailFromName($emailFromName) {
        $this->emailFromName = $emailFromName;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEmailFromName() {
        return $this->emailFromName;
    }

    /**
     * {@inheritDoc}
     */
    public function setReplyTo($replyTo) {
        $this->replyTo = $replyTo;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getReplyTo() {
        return $this->replyTo;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setEnableRegistration($enableRegistration) {
        $this->enableRegistration = $enableRegistration;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnableRegistration() {
        return $this->enableRegistration;
    }

    /**
     * {@inheritDoc}
     */
    public function setUserFormTimeout($userFormTimeout) {
        $this->userFormTimeout = $userFormTimeout;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserFormTimeout() {
        return $this->userFormTimeout;
    }

    /**
     * {@inheritDoc}
     */
    public function setLoginAfterRegistration($loginAfterRegistration) {
        $this->loginAfterRegistration = $loginAfterRegistration;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLoginAfterRegistration() {
        return $this->loginAfterRegistration;
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultUserState() {
        return $this->defaultUserState;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultUserState($state) {
        $this->defaultUserState = $state;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setRegistrationEmailSubjectLine($registerSubjectLine) {
        $this->registrationEmailSubjectLine = $registerSubjectLine;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRegistrationEmailSubjectLine() {
        return $this->registrationEmailSubjectLine;
    }

    /**
     * {@inheritDoc}
     */
    public function setRegistrationEmailTemplate($registerEmailTemplate) {
        $this->registrationEmailTemplate = $registerEmailTemplate;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRegistrationEmailTemplate() {
        return $this->registrationEmailTemplate;
    }

    /**
     * {@inheritDoc}
     */
    public function setRegistrationViewTemplate($registerViewTemplate) {
        $this->registrationViewTemplate = $registerViewTemplate;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRegistrationViewTemplate() {
        return $this->registrationViewTemplate;
    }

        /**
     * {@inheritDoc}
     */
    public function setAuthIdentityFields($authIdentityFields) {
        $this->authIdentityFields = $authIdentityFields;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthIdentityFields() {
        return $this->authIdentityFields;
    }

    /**
     * {@inheritDoc}
     */
    public function setEnableUsername($flag) {
        $this->enableUsername = (bool) $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnableUsername() {
        return $this->enableUsername;
    }

    /**
     * {@inheritDoc}
     */
    public function setEnableDisplayName($flag) {
        $this->enableDisplayName = (bool) $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnableDisplayName() {
        return $this->enableDisplayName;
    }

    /**
     * {@inheritDoc}
     */
    public function setUseRegistrationFormCaptcha($useRegistrationFormCaptcha) {
        $this->useRegistrationFormCaptcha = $useRegistrationFormCaptcha;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUseRegistrationFormCaptcha() {
        return $this->useRegistrationFormCaptcha;
    }

    /**
     * {@inheritDoc}
     */
    public function setUserEntityClass($userEntityClass) {
        $this->userEntityClass = $userEntityClass;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserEntityClass() {
        return $this->userEntityClass;
    }

    /**
     * {@inheritDoc}
     */
    public function setFormCaptchaOptions($formCaptchaOptions) {
        $this->formCaptchaOptions = $formCaptchaOptions;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getFormCaptchaOptions() {
        return $this->formCaptchaOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function setRegistrationFormFactory($registrationFormFactory) {
        $this->registrationFormFactory = $registrationFormFactory;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRegistrationFormFactory() {
        return $this->registrationFormFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultUserRoles($defaultRoles) {
        $this->defaultRoles = $defaultRoles;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultUserRoles() {
        return $this->defaultRoles;
    }

    /**
     * {@inheritDoc}
     */
    public function setEnableEmailVerification($flag) {
        $this->enableEmailVerification = $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnableEmailVerification() {
        return $this->enableEmailVerification;
    }

    /**
     * {@inheritDoc}
     */
    public function setChangeProfileFormFactory($changeProfileFormFactory) {
        $this->changeProfileFormFactory = $changeProfileFormFactory;
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getChangeProfileFormFactory() {
        return $this->changeProfileFormFactory;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setChangeProfileViewTemplate($changeProfileViewTemplate) {
        $this->changeProfileViewTemplate = $changeProfileViewTemplate;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getChangeProfileViewTemplate() {
        return $this->changeProfileViewTemplate;
    }

    /**
     * {@inheritDoc}
     */
    public function setForgotPasswordEmailSubjectLine($subject) {
        $this->forgotPasswordEmailSubjectLine = $subject;
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getForgotPasswordEmailSubjectLine() {
        return $this->forgotPasswordEmailSubjectLine;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setForgotPasswordEmailTemplate($template) {
        $this->forgotPasswordEmailTemplate = $template;
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getForgotPasswordEmailTemplate() {
        return $this->forgotPasswordEmailTemplate;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setResetExpire($resetExpireTime) {
        $this->resetExpire = $resetExpireTime;
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getResetExpire() {
        return $this->resetExpire;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setUseSmtp($flag) {
        $this->useSmtp = $flag;
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getUseSmtp() {
        return $this->useSmtp;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setSmtpOptions($smtpOptions) {
        $this->smtpOptions = $smtpOptions;
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSmtpOptions() {
        return $this->smtpOptions;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setMailerServiceFactory($mailerServiceFactory) {
        $this->mailerServiceFactory = $mailerServiceFactory;
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getMailerServiceFactory() {
        return $this->mailerServiceFactory;
    }
}
