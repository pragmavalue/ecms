<?php
namespace Application\Form;

use Application\Entity\Product;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;
use Zend\Validator;
use Application\Form\Validator as CustomValidator;

class UserInfoFieldset extends Fieldset implements InputFilterProviderInterface
 {
     public function __construct()
     {
         parent::__construct('user_info');

         $this->add(array(
             'name' => 'gender',
             'type' => Element\Radio::class,
             'options' => array(
                'label' => 'Płeć',
                'value_options' => [
                    'male' => 'Mężczyzna',
                    'female' => 'Kobieta',
                ]
             ),
             'attributes' => array(
                 'required' => 'required'
             ),
         ));
         
        $this->add(array(
            'name' => 'education',
            'type' => Element\Select::class,
            'options' => array(
               'label' => 'Wykształcenie',
               'value_options' => [
                   'primary' => 'Podstawowe',
                   'college' => 'Gimnazjalne',
                   'highschool' => 'Licealne',
                   'graduate' => 'Wyższe'
               ]
            ),
            'attributes' => array(
                'required' => 'required'
            ),
        ));

        $this->add(array(
            'name' => 'hobby',
            'type' => Element\MultiCheckbox::class,
            'options' => array(
               'label' => 'Zainteresowania',
               'value_options' => [
                   'books' => 'Książki',
                   'sport' => 'Sport',
                   'movies' => 'Filmy',
                   'music' => 'Muzyka'
               ]
            ),
            
        ));
     }

    public function getInputFilterSpecification()
    {
        return array(
            'gender' => array(
                'required' => true,
                'validators' => [$this->getAlphaValidator()]
            ),
            'education' => array(
                'required' => true,
                'validators' => [$this->getAlphaValidator()]
            ),
            'hobby' => array(
                'required' => true
            )
        );
    }
    
    private function getAlphaValidator()
    {
        return [
            'name' => CustomValidator\Alpha::class
        ];
    }
 }