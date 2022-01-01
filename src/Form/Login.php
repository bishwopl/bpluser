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
                'type' => 'text',
                'required' => 'true'
            ],
        ]);
        
        $this->add([
            'name' => 'credential',
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
                'class' => 'btn btn-success'
            ]);
        $this->add($submitElement);
    }
    
}
