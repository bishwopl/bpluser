<?php

namespace BplUser\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use BplUser\Contract\AuthenticationOptionsInterface;

class Login extends Form {

    /**
     * @var AuthenticationOptionsInterface
     */
    protected $authOptions;

    public function __construct($name, AuthenticationOptionsInterface $options) {
        $this->authOptions = $options;
        parent::__construct($name);
        
        $this->add([
            'name' => 'identity',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'placeholder' => "Username",
                'type' => 'text',
                'required' => 'true',
                'class' => 'form-control form-control-user'
            ],
        ]);
        
        $this->add([
            'name' => 'credential',
            'type' => 'password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'placeholder' => "Password",
                'type' => 'password',
                'required' => 'true',
                'class' => 'form-control form-control-user'
            ],
        ]);
        
        $this->add([
            'name' => 'redirect',
            'type' => 'hidden',
            'options' => [
                'label' => '',
            ],
            'attributes' => [
                'type' => 'hidden',
            ],
        ]);
        
        $csrf = new Element\Csrf('csrf');
        $csrf->getCsrfValidator()->setTimeout($options->getLoginFormTimeout());
        $this->add($csrf);
        
        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Sign In')
            ->setAttributes([
                'type'  => 'submit',
                'class' => 'btn btn-primary btn-user btn-block'
            ]);
        $this->add($submitElement);
    }
    
}
