<?php
namespace Application\Form;

use Zend\Form\Element;

class UserForm extends \Zend\Form\Form
{
    public function __construct($name = 'user')
    {
        parent::__construct($name);

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => 'username',
            'type' => 'text',
            'options' => [
                'label' => 'Nazwa'
            ]
        ]);
        $this->add([
            'name' => 'email',
            'type' => Element\Email::class,
            'options' => [
                'label' => 'Adres email'
            ],
            'attributes' => array(
                 'required' => 'required'
             )
        ]);
        $this->add([
            'type' => UserInfoFieldset::class,
            'name' => 'user_info',
            'options' => [
                
            ]
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Zapisz',
                'id'    => 'saveUserForm'
            ]
        ]);
        //domyślnie jest to również POST
        $this->setAttribute('method', 'POST');
    }
}