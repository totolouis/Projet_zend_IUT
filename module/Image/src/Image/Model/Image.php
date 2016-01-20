<?php
namespace Image\Model;

 // Add these import statements
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 class Image implements InputFilterAwareInterface
 {
     public $id;
     public $lien;
     public $idMembre;
     public $username;
     public $Expression1;
     public $idUser;
     protected $inputFilter;                    

       public function exchangeArray($data)
     {
         $this->id = (isset($data['id'])) ? $data['id'] : null;
         $this->lien = (isset($data['lien'])) ? $data['lien'] : null;
         $this->idMembre  = (isset($data['idMembre']))  ? $data['idMembre']  : null;
         
         $this->username  = (isset($data['username']))  ? $data['username']  : null;
         $this->idUser  = (isset($data['user.id']))  ? $data['user.id']  : null;
         $this->Expression1  = (isset($data['Expression1']))  ? $data['Expression1']  : null;
     }

     // Add the following method:
                                                    
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }

     // Add content to these methods:
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'lien',
                 'required' => true,
                 'options' => [
                          'target' => realpath('./BanqueImage'),
                          'randomize' => true,
                          'use_upload_extension' => true,
                 ],
                 'validators' => array(
                    array(
                        'name' => 'Zend\Validator\File\Size',
                        'options' => array(
                            'max' => 20000,
                            ),
                        'name' => 'Zend\Validator\File\Extension',
                        'options' => array(
                            'extension' => 'png, jpg, jpeg',
                            ),
                        ),
                    ),
             ));

             $inputFilter->add(array(
                 'name'     => 'idMembre',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }