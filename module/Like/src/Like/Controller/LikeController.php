<?php
namespace Like\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Like\Model\Like;          
 use Like\Form\LikeForm; 
 
 use Zend\Authentication\AuthenticationService;
 use Zend\Session\Container;

 class LikeController extends AbstractActionController
 {
     
     protected $likeTable;
     protected $userTable;
     
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
 // ...
     public function indexAction()
     {
         
     }
     
     public function addAction()
     {
        $logged = $this->getConnection();
        
        //verifier que le membre ne like pas sa propre image
        //verifier que le membre n'a pas déjà liker cette image
        
     }
     
     public function deleteAction()
     {
         
     }
 }