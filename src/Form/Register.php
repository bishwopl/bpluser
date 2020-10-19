<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use BplUser\Provider\RegistrationOptionsInterface;

class Register extends Form {

    /**
     *
     * @var RegistrationOptionsInterface 
     */
    protected $registerOptions;

    public function __construct($name, RegistrationOptionsInterface $registerOptions) {
        parent::__construct($name);
        $this->registerOptions = $registerOptions;

        $this->add([
            'name' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'type' => 'text',
                'required' => 'true'
            ],
        ]);

        if (!$registerOptions->getEnableEmailVerification()) {
            $this->add([
                'name' => 'password',
                'type' => 'password',
                'options' => [
                    'label' => 'Password',
                ],
                'attributes' => [
                    'type' => 'password',
                    'required' => 'true'
                ],
            ]);

            $this->add([
                'name' => 'password_verify',
                'type' => 'password',
                'options' => [
                    'label' => 'Verify Password',
                ],
                'attributes' => [
                    'type' => 'password',
                    'required' => 'true'
                ],
            ]);
        }
        if ($this->registerOptions->getUseRegistrationFormCaptcha()) {
            $this->add([
                'name' => 'captcha',
                'type' => \Laminas\Form\Element\Captcha::class,
                'options' => [
                    'label' => 'Please type the following text',
                    'captcha' => $this->registerOptions->getFormCaptchaOptions(),
                ],
                'attributes' => [
                    'required' => 'true'
                ],
            ]);
        }

        $csrf = new Element\Csrf('csrf');
        $csrf->getCsrfValidator()->setTimeout($registerOptions->getLoginFormTimeout());
        $this->add($csrf);

        $submitElement = new Element\Button('submit');
        $submitElement
                ->setLabel('Register')
                ->setAttributes([
                    'type' => 'submit',
                    'class' => 'btn btn-success'
        ]);
        $this->add($submitElement);
    }

}
