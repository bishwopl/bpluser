<?php

namespace BplUser\Contract;

interface RegistrationOptionsInterface {

    /**
     * set enable user registration
     *
     * @param bool $enableRegistration
     */
    public function setEnableRegistration($enableRegistration);

    /**
     * get enable user registration
     *
     * @return bool
     */
    public function getEnableRegistration();

    /**
     * set user form timeout in seconds
     *
     * @param int $userFormTimeout
     */
    public function setUserFormTimeout($userFormTimeout);

    /**
     * get user form timeout in seconds
     *
     * @return int
     */
    public function getUserFormTimeout();

    /**
     * set whether to enable email verification or not
     * @param bool $flag
     */
    public function setEnableEmailVerification($flag);
    
    /**
     * check whether to enable email verification or not
     */
    public function getEnableEmailVerification();

    /**
     * set login after registration
     *
     * @param bool $loginAfterRegistration
     * @return ModuleOptions
     */
    public function setLoginAfterRegistration($loginAfterRegistration);

    /**
     * get login after registration
     *
     * @return bool
     */
    public function getLoginAfterRegistration();

    /**
     * set use a captcha in registration form
     *
     * @param bool $useRegistrationFormCaptcha
     * @return ModuleOptions
     */
    public function setUseRegistrationFormCaptcha($useRegistrationFormCaptcha);

    /**
     * get use a captcha in registration form
     *
     * @return bool
     */
    public function getUseRegistrationFormCaptcha();

    /**
     * set form CAPTCHA options
     *
     * @param array $formCaptchaOptions
     * @return ModuleOptions
     */
    public function setFormCaptchaOptions($formCaptchaOptions);

    /**
     * get form CAPTCHA options
     *
     * @return array
     */
    public function getFormCaptchaOptions();

    /**
     * set default user state for new user
     * @param int $state
     */
    public function setDefaultUserState($state);

    /**
     * get default user state for new user
     */
    public function getDefaultUserState();

    /**
     * set default roles to give to newly registered user
     * 
     * @param array $defaultRoles
     */
    public function setDefaultUserRoles($defaultRoles);

    /**
     * get default roles to give to newly registered user
     */
    public function getDefaultUserRoles();

    /**
     * Set registration form factory name
     * this will enable custom registration form to be 
     * injected in registration controller
     * 
     * @param string $registrationFormFactory
     */
    public function setRegistrationFormFactory($registrationFormFactory);

    /**
     * get registration form factory name
     */
    public function getRegistrationFormFactory();

    /**
     * Set subject for email notification sent to newly registered user
     * @param string $registerSubjectLine
     */
    public function setRegistrationEmailSubjectLine($registerSubjectLine);

    /**
     * get subject for email notification sent to newly registered user
     */
    public function getRegistrationEmailSubjectLine();

    /**
     * Set view template for email which will be used to create HTML email to
     * notify user of registration
     * @param type $registerEmailTemplate
     */
    public function setRegistrationEmailTemplate($registerEmailTemplate);

    /**
     * Get view template for email which
     */
    public function getRegistrationEmailTemplate();
}
