<?php
namespace BplUser\Form\Filter;
use Zend\InputFilter\InputFilter;
 
class ForgotFilter extends InputFilter {
 
    public function __construct() {
 
        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => \Zend\Filter\StringTrim::class]
            ],
            'validators' => [
                [
                    'name' => \Zend\Validator\EmailAddress::class
                ]
            ],
        ]);
    }
}