<?php
namespace BplUser\Form\Filter;
use Laminas\InputFilter\InputFilter;
 
class ForgotFilter extends InputFilter {
 
    public function __construct() {
 
        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => \Laminas\Filter\StringTrim::class]
            ],
            'validators' => [
                [
                    'name' => \Laminas\Validator\EmailAddress::class
                ]
            ],
        ]);
    }
}