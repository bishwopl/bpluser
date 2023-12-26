<?php

namespace BplUser\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use CirclicalUser\Mapper\UserAtomMapper;
use CirclicalUser\Entity\UserAtom;
use Laminas\View\Model\ViewModel;
use Laminas\Form\Form;
use BplUser\Contract\BplUserInterface;

class UserAtomController extends AbstractActionController {

    /**
     * @var \BplUser\Contract\BplUserInterface
     */
    protected $currentUser;
    
    /**
     * @var array
     */
    protected $userAtomKeys;
    
    /**
     * @var \CirclicalUser\Mapper\UserAtomMapper
     */
    protected $userAtomMapper;

    public function __construct(BplUserInterface $currentUser, array $userAtomKeys, UserAtomMapper $userAtomMapper) {
        $this->currentUser = $currentUser;
        $this->userAtomKeys = $userAtomKeys;
        $this->userAtomMapper = $userAtomMapper;
    }

    public function indexAction(): ViewModel {
        /* @var $value \CirclicalUser\Entity\UserAtom */
        $vm = new ViewModel();
        
        $formData = [];
        
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost()->toArray();
            foreach($this->userAtomKeys as $atom){
                $keyName = $atom['keyName'];
                $value = $this->userAtomMapper->getAtom($this->currentUser, $keyName);
                if($value instanceof UserAtom){
                    $formData[$keyName] = $value->setValue($formData[$keyName]);
                    $this->userAtomMapper->update($value);
                    
                }else{
                    $value = new UserAtom($this->currentUser, $keyName, $formData[$keyName]);
                    $this->userAtomMapper->save($value);
                }
            }
            $vm->setVariable('infoChanged', true);
        }
        foreach($this->userAtomKeys as $atom){
            $keyName = $atom['keyName'];
            $value = $this->userAtomMapper->getAtom($this->currentUser, $keyName);
            if($value instanceof UserAtom){
                $formData[$keyName] = $value->getValue();
            }
        }
        
        $form = new Form('user-atom-edit-form');
        $form->setAttribute("method", "POST");
        $form->setAttribute("action", $this->url()->fromRoute('bpl-user/user-atoms'));
        
        foreach($this->userAtomKeys as $atom){
            $keyName = $atom['keyName'];
            $keyDescrption = $atom['keyDescrption'];
            
            $element = new \Laminas\Form\Element\Textarea($keyName);
            $element->setLabel($keyDescrption);
            $element->setAttribute("class", "form-control input");
            $form->add($element);
        }
        
        $submitElement = new \Laminas\Form\Element\Button('submit');
        $submitElement
            ->setLabel('Submit Information')
            ->setAttributes([
                'type'  => 'submit',
                'class' => 'btn btn-info'
            ]);
        $form->add($submitElement);
        
        $form->setData($formData);
        
        $vm->setVariable('form', $form);
        return $vm;
    }

}
