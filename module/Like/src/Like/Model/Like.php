<?php
namespace Like\Model;

 // Add these import statements
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 class Like implements InputFilterAwareInterface
 {
     public $id;
     public $idImage;
     public $idLiker;
     protected $inputFilter;                    

       public function exchangeArray($data)
     {
         $this->id = (isset($data['id'])) ? $data['id'] : null;
         $this->idImage = (isset($data['idImage'])) ? $data['idImage'] : null;
         $this->idLiker  = (isset($data['$idLiker']))  ? $data['$idLiker']  : null;
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

    public function getInputFilter() {}

}