<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class ChangeProfile extends Form {

    public function __construct($name) {
        parent::__construct($name);

        $this->add([
            'name' => 'firstName',
            'options' => [
                'label' => 'First Name',
            ],
            'attributes' => [
                'type' => 'text',
                'required' => 'true'
            ],
        ]);

        $this->add([
            'name' => 'lastName',
            'options' => [
                'label' => 'Last Name',
            ],
            'attributes' => [
                'type' => 'text',
                'required' => 'true'
            ],
        ]);

        $this->add([
            'name' => 'address',
            'options' => [
                'label' => 'Address',
            ],
            'attributes' => [
                'type' => 'text',
            ],
        ]);

        $this->add([
            'name' => 'phone',
            'options' => [
                'label' => 'Contact No',
            ],
            'attributes' => [
                'type' => 'text',
            ],
        ]);

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
