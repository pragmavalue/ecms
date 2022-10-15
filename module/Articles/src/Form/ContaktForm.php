<?php

namespace Articles\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element\Textarea;

class ContaktForm extends Form
{
    
    public function __construct()
    {
        // Define form name
        parent::__construct('post-form');
     
        // Set POST method for this form
        $this->setAttribute('method', 'post');
                
        $this->addElements();
        $this->addInputFilter();  
        

    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() 
    {
                
        // Add "title" field
        $this->add([        
            'type'  => 'text',
            'name' => 'title',
            'attributes' => [
                'id' => 'title'
            ],
            'options' => [
                'label' => 'Title',
            ],
        ]);
        
         // Add "tags" field
        $this->add([        
            'type'  => 'text',
            'name' => 'author',
            'attributes' => [
                'id' => 'author`'
            ],
            'options' => [
                'label' => 'Author',
            ],
        ]);
        
        $this->add([        
            'type'  => 'text',
            'name' => 'email',
            'attributes' => [
                'id' => 'email`'
            ],
            'options' => [
                'label' => 'Email',
            ],
        ]);
        // Add "content" field
        $this->add([
            'type'  => Textarea::class,
            'name' => 'content',
            'attributes' => [                
                'id' => 'content'
            ],
            'options' => [
                'label' => 'Info',
            ],
        ]);
        
        $this->add([
            'type' => 'captcha',
            'name' => 'captcha',
            'options' => [
                'label' => 'Human',
                'captcha' => [
                    'class' => 'Image',
                    'imgDir' => './public/img/captcha/',
                    'suffix' => '.png',
                    'imgUrl' => '../img/captcha',
                    'imgAlt' => 'CAPTCHA Image',
                    'font' => realpath('./data/files/FreeSansBold.ttf'),
                    'fsize' => 32,
                    'width' => 350,
                    'height' => 110,
                    'expiration' => 600,
                    'dotNoiseLevel' => 90,
                    'lineNoiseLevel' => 8
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'csrf',
            'type' => 'csrf',
            'options' => [
                'csrf_options' => [
                'timeout' => 600,
                ],
            ],
        ]);


        
        // Add the submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [                
                'value' => 'Wyślij',
                'id' => 'submitbutton',
            ],
        ]);
    }
    
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() 
    {
        
        $inputFilter = new InputFilter();        
        $this->setInputFilter($inputFilter);
        
        $inputFilter->add([
                'name'     => 'title',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags'],
                    
                ],                
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 1024
                        ],
                    ],
                ],
            ]);
        
        $inputFilter->add([
                'name'     => 'content',
                'required' => true,
                'filters'  => [                    
                    ['name' => 'StringTrim'],
                    ['name' => 'StripNewlines'],
                   
                ],                
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 4096
                        ],
                    ],
                ],
            ]);
        $inputFilter->add([
        
                'name'     => 'email',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],                    
                ],                
                'validators' => [
                    [
                        'name' => 'EmailAddress',
                        'options' => [
                            'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                            'useMxCheck'    => false,                            
                        ],
                    ],
                ],
            ]);                   

    }
}

