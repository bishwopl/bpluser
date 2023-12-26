<?php
namespace BplUser\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use BplUser\Contract\ForgotPasswordOptionsInterface;
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
                'required' => 'true',
                'class' => 'form-control form-control-user'
            ],
        ]);
        
        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Request new password')
            ->setAttributes([
                'type'  => 'submit',
                'class' => 'btn btn-primary'
            ]);
        $this->add($submitElement);
    }
}