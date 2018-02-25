<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use BplUser\Provider\AuthenticationOptionsInterface;

class ChangeEmail extends Form {

    /**
     *
     * @var AuthenticationOptionsInterface 
     */
    protected $authOptions;

    public function __construct($name, AuthenticationOptionsInterface $authOptions) {
        parent::__construct($name);
        $this->authOptions = $authOptions;

        $this->add([
            'name' => 'email',
            'options' => [
                'label' => 'New Email Address',
            ],
            'attributes' => [
                'type' => 'text',
                'required' => 'true'
            ],
        ]);

        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'Your Current Password',
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
