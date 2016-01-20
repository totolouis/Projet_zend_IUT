<?php
    namespace Image\Model;

 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db;

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
     
     public function get20BestPics()
     {
         $sqlSelect = $this->tableGateway->getSql()->select();
         $sqlSelect->columns(array('idMembre', 'lien', new Db\Sql\Predicate\Expression('COUNT(*)') ));
         $sqlSelect->join('like', 'like.idImage = image.id', array('idLiker'), 'inner');
         $sqlSelect->join('user', 'image.idMembre = user.id', array('username', 'id'), 'inner');
         $sqlSelect->group('image.id');
         $sqlSelect->order(array('Expression1 DESC'));
         $sqlSelect->limit(20);
         
         $resultSet = $this->tableGateway->selectWith($sqlSelect);
         
         return $resultSet;
     }

     public function saveImage(Image $image)
     {
         $data = array(
             'lien' => $image->lien,
             'idMembre'  => $image->idMembre,
         );

         $id = (int) $image->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getImage($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Image id does not exist');
             }
         }
     }

     public function deleteImage($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
?>