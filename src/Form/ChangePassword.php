<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use BplUser\Provider\AuthenticationOptionsInterface;

class ChangePassword extends Form {

    /**
     *
     * @var AuthenticationOptionsInterface 
     */
    protected $authOptions;

    public function __construct($name, AuthenticationOptionsInterface $authOptions) {
        parent::__construct($name);
        $this->authOptions = $authOptions;

        $this->add([
            'name' => 'current_password',
            'options' => [
                'label' => 'Your Current Password',
            ],
            'attributes' => [
                'type' => 'password',
                'required' => 'true'
            ],
        ]);

        $this->add([
            'name' => 'new_password',
            'type' => 'password',
            'options' => [
                'label' => 'New Password',
            ],
            'attributes' => [
                'type' => 'password',
                'required' => 'true'
            ],
        ]);
        
        $this->add([
            'name' => 'new_password_verify',
            'type' => 'password',
            'options' => [
                'label' => 'Verify New Password',
            ],
            'attributes' => [
                'type' => 'password',
                'required' => 'true'
            ],
        ]);

        $csrf = new Element\Csrf('csrf');
        $csrf->getCsrfValidator()->setTimeout($authOptions->getLoginFormTimeout());
        $this->add($csrf);

        $submitElement = new Element\Button('submit');
        $submitElement
                ->setLabel('Submit')
                ->setAttributes([
                    'type' => 'submit',
                    'class' => 'btn btn-success'
        ]);
        $this->add($submitElement);
    }

}
