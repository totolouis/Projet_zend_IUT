<?php 
namespace Image\Form;

 use Zend\Form\Form;


 class ImageForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('image');
         
         $this->add(array(
             'name' => 'lien',
             'type' => 'file',
             'options' => array(
                 'label' => 'Choose a Pic (PNG, JPG)',
             ),
         ));
         $this->add(array(
             'name' => 'idMembre',
             'attributes' => array(
                 'type' => 'hidden',
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }