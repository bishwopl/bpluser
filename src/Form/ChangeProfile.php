<?php

/**
 * 
 * @author Bishwo Prasad Lamichhane <bishwo.prasad@gmail.com>
 */

namespace BplUser\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Ramsey\Uuid\Uuid;

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
                'required' => 'true',
                'class' => 'form-control form-control-user'
            ],
        ]);

        $this->add([
            'name' => 'lastName',
            'options' => [
                'label' => 'Last Name',
            ],
            'attributes' => [
                'type' => 'text',
                'required' => 'true',
                'class' => 'form-control form-control-user'
            ],
        ]);
        
        /*
        $this->add([
            'type' => \LaminasFileUpload\Form\Element\FileUpload::class,
            'name' => 'avatar',
            'attributes' => [
                'formUniqueId'      => 'photo_'.Uuid::uuid4(),
                'id'                => 'photoPathId',
                'storage'           => 'filesystem', // 'filesystem' or 'db' or 'hybrid'
                'showProgress'      => true,
                'multiple'          => false,
                'enableRemove'      => false,
                'uploadDir'         => 'data/UserData/',
                'icon'              => 'fas fa-edit',
                'successIcon'       => 'fas fa-edit',
                'errorIcon'         => 'fas fa-remove',
                'class'             => 'btn btn-info',
                'uploadText'        => 'Change Profile Picture',
                'successText'       => 'Change Profile Picture',
                'errorText'         => 'Try Again',
                'uploadingText'     => 'Uploading ...',
                'replacePrevious'   => true,
                'randomizeName'     => true,
                'showPreview'       => true,
                'validator' => [ 
                    'allowedExtensions' => 'jpg,png',
                    'allowedMime'       => 'image/jpeg,image/png',
                    'minSize'           => 10,
                    'maxSize'           => 1*1024*1024,
                    'image' => [
                        'minWidth'  => 0,
                        'minHeight' => 0,
                        'maxWidth'  => 12000,
                        'maxHeight' => 10000,
                    ],
                ],
                'crop' => [
                    'width'  => 100,
                    'height' => 100,
                ],
                'preview'=>[
                    'width'  => 100,
                    'height' => 100,
                ],
                'callback'=>[
                    [
                        'object'    => \BplUser\Service\BplUserService::class,
                        'function'  => 'changeProfilePicturePath',
                        'parameter' => []
                    ]
                ]
            ],
            'options' => [
                'label' => 'Profile Picture',
            ],
        ]);
         * 
         */
        
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
