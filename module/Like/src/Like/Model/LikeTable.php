<?php
    namespace Like\Model;

 use Zend\Db\TableGateway\TableGateway;

 class LikeTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAllById($id)
     {
         $resultSet = $this->tableGateway->select(array('id' => $id));
         return $resultSet;
     }
     
     public function fetchAllByUser($id)
     {
         $resultSet = $this->tableGateway->select(array('idLiker' => $id));
         return $resultSet;
     }
     
     public function fetchCorrespondance($id, $idImage)
     {
         $resultSet = $this->tableGateway->select(array('idLiker' => $id, 'idImage' => $idImage));
         return $resultSet;
     }
     
     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function saveLike($image, $idMembre)
     {
         $data = array(
             'idLiker' => $idMembre,
             'idImage'  => $image->id,
         );
         
         $this->tableGateway->insert($data);
         
     }

     public function deleteLike($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
?>