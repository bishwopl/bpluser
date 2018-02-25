<?php
namespace BplUser\Form\Filter;
use Zend\InputFilter\InputFilter;
 
class LoginFilter extends InputFilter {
 
    public function __construct() {
 
        $this->add([
            'name' => 'identity',
            'required' => true,
            'filters' => [
                ['name' => \Zend\Filter\StringTrim::class]
            ],
        ]);
        
        $this->add([
            'name' => 'credential',
            'required' => true,
        ]);
        
        $this->add([
            'name' => 'csrf',
            'required' => true,
            'validators' => [
                [
                    'name' => \Zend\Validator\Csrf::class
                ]
            ]
        ]);
    }
}