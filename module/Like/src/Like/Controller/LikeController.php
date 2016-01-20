<?php
namespace Like\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Like\Model\LikeTable;          
 
 use Zend\Authentication\AuthenticationService;
 use Zend\Session\Container;

 class LikeController extends AbstractActionController
 {
     
     protected $likeTable;
     protected $userTable;
     protected $imageTable;
     
     public function getLikeTable()
     {
         if (!$this->likeTable) {
             $sm = $this->getServiceLocator();
             $this->likeTable = $sm->get('Like\Model\LikeTable');
         }
         return $this->likeTable;
     }
     
     public function getUserTable(){
    	if (!$this->userTable){
    		$sm = $this->getServiceLocator();
    		$this->userTable = $sm->get('User\Model\UserTable');
    	}
    	return $this->userTable;
    }
    
    public function getImageTable()
     {
         if (!$this->imageTable) {
             $sm = $this->getServiceLocator();
             $this->imageTable = $sm->get('Image\Model\ImageTable');
         }
         return $this->imageTable;
     }
     
     public function getConnection(){
         $auth = new AuthenticationService();
         $logged = null;
         if ($auth->hasIdentity()){
             $session = new Container('user');
             $logged = $session->offsetGet('id');
         }
        
         if ($logged === null): return $this->redirect()->toRoute('user', array('action' => 'signin')); endif;
         
         return $logged;
     }
     
     public function isLiked($logged, $idImage){
        $like = $this->getLikeTable()->fetchCorrespondance($logged, $idImage);
        foreach ($like as $liked):
            if($liked->id != null): return TRUE; endif;
        endforeach; 
        
        return FALSE;
     }
     
     public function isHisImage($logged, $idImage){
        $image = $this->getImageTable()->getImage($idImage);
        $idMembrePostImage = $image->idMembre;
        
        if($logged == $idMembrePostImage): return TRUE; endif;
        
        return FALSE;
     }
 // ...
     public function indexAction()
     {
         return $this->redirect()->toRoute('image');
     }
     
     public function addAction()
     {
        $logged = $this->getConnection();
        
        $idImage = (int) $this->params()->fromRoute('id', 0);
        if (!$idImage) {
             return $this->redirect()->toRoute('image');
        }
         
        $image = $this->getImageTable()->getImage($idImage);
        $idMembrePostImage = $image->idMembre;
        
        //verifier que le membre ne like pas sa propre image
        if($this->isHisImage($logged, $idImage)):return $this->redirect()->toRoute('image', array('action' => 'membre', 'id' => $idMembrePostImage)); endif;
        
        //verifier que le membre n'a pas déjà liker cette image
        if($this->isLiked($logged, $image->id)): return $this->redirect()->toRoute('image', array('action' => 'membre', 'id' => $idMembrePostImage)); endif;
        
        $this->getLikeTable()->saveLike($image, $logged);
        
        return $this->redirect()->toRoute('image', array('action' => 'membre', 'id' => $idMembrePostImage));
     }
     
     public function deleteAction()
     {
        $logged = $this->getConnection();
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
             return $this->redirect()->toRoute('image');
        }
        $imageTest = $this->getLikeTable()->fetchCorrespondance($logged, $id);
        $idLike = null;
        foreach ($imageTest as $img):
            $idLike = $img->id;
        endforeach;
        
        if($idLike == null): return $this->redirect()->toRoute('image');endif;
        
        $like = $this->getLikeTable()->fetchAllById($idLike);
        
        $image = null;
        foreach ($like as $hisLike):
            $image = $this->getImageTable()->getImage($hisLike->idImage);
        endforeach; 
        
        $this->getLikeTable()->deleteLike($idLike);
        if($image != null): return $this->redirect()->toRoute('image', array('action' => 'membre', 'id' => $image->idMembre));endif;
        
        return $this->redirect()->toRoute('image');
     }
 }