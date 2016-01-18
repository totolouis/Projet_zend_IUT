<?php
    namespace Image\Model;

 use Zend\Db\TableGateway\TableGateway;

 class ImageTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAllById($id)
     {
         $resultSet = $this->tableGateway->select(array('idMembre' => $id));
         return $resultSet;
     }
     
     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getImage($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveLike($image)
     {
         
     }

     public function deleteLike($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
?>