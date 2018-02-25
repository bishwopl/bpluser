<?php
namespace BplUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use BplUser\Provider\ForgotPasswordOptionsInterface;
class Forgot extends Form{
    /**
     * @var AuthenticationOptionsInterface
     */
    protected $forgotPasswordOptions;

    public function __construct($name, ForgotPasswordOptionsInterface $forgotPasswordOptions) {
        $this->forgotPasswordOptions = $forgotPasswordOptions;
        parent::__construct($name);
        
        $this->add([
            'name' => 'email',
            'options' => [
                'label' => 'Your Email Address',
            ],
            'attributes' => [
                'type' => 'text',
                'required' => 'true'
            ],
        ]);
        
        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Request new password')
            ->setAttributes([
                'type'  => 'submit',
                'class' => 'btn btn-success'
            ]);
        $this->add($submitElement);
    }
}