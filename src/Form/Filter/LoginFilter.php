<?php
namespace BplUser\Form\Filter;
use Laminas\InputFilter\InputFilter;
 
class LoginFilter extends InputFilter {
 
    public function __construct() {
 
        $this->add([
            'name' => 'identity',
            'required' => true,
            'filters' => [
                ['name' => \Laminas\Filter\StringTrim::class]
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
                    'name' => \Laminas\Validator\Csrf::class
                ]
            ]
        ]);
    }
}