<?php

namespace BplUser\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class ResetPassword extends Form {

    public function __construct($name) {
        parent::__construct($name);

        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'New Password',
            ],
            'attributes' => [
                'type' => 'password',
                'required' => 'true',
                'class' => 'form-control form-control-user'
            ],
        ]);

        $this->add([
            'name' => 'password_verify',
            'type' => 'password',
            'options' => [
                'label' => 'Verify New Password',
            ],
            'attributes' => [
                'type' => 'password',
                'required' => 'true',
                'class' => 'form-control form-control-user'
            ],
        ]);

        $submitElement = new Element\Button('submit');
        $submitElement
                ->setLabel('Reset Password')
                ->setAttributes([
                    'type' => 'submit',
                    'class' => 'btn btn-success'
        ]);
        $this->add($submitElement);
    }

}
