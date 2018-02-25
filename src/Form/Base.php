<?php

namespace BplUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class Base extends Form {

    public function __construct() {
        parent::__construct();
        $this->add([
            'name' => 'username',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'type' => 'text'
            ],
        ]);

        $this->add([
            'name' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'type' => 'text'
            ],
        ]);

        $this->add([
            'name' => 'display_name',
            'options' => [
                'label' => 'Display Name',
            ],
            'attributes' => [
                'type' => 'text'
            ],
        ]);

        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'type' => 'password'
            ],
        ]);

        $this->add([
            'name' => 'passwordVerify',
            'type' => 'password',
            'options' => [
                'label' => 'Password Verify',
            ],
            'attributes' => [
                'type' => 'password'
            ],
        ]);

        $submitElement = new Element\Button('submit');
        $submitElement
                ->setLabel('Submit')
                ->setAttributes([
                    'type' => 'submit',
        ]);

        $this->add($submitElement, [
            'priority' => -100,
        ]);

        $this->add([
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);

        $csrf = new Element\Csrf('csrf');
        $csrf->getValidator()->setTimeout($this->getRegistrationOptions()->getUserFormTimeout());
        $this->add($csrf);
    }

}
