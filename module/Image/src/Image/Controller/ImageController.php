<?php
namespace Image\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Image\Model\Image;          
 use Image\Form\ImageForm; 
 
 use Like\Controller\LikeController;
 
 use Zend\Authentication\AuthenticationService;
 use Zend\Session\Container;

 class ImageController extends AbstractActionController
 {
     protected $imageTable;
     protected $userTable;
     protected $likeTable;
     
     public function getImageTable()
     {
         if (!$this->imageTable) {
             $sm = $this->getServiceLocator();
             $this->imageTable = $sm->get('Image\Model\ImageTable');
         }
         return $this->imageTable;
     }
     
     public function getUserTable()
     {
    	if (!$this->userTable){
    		$sm = $this->getServiceLocator();
    		$this->userTable = $sm->get('User\Model\UserTable');
    	}
    	return $this->userTable;
     }
     
     public function getLikeTable()
     {
         if (!$this->likeTable) {
             $sm = $this->getServiceLocator();
             $this->likeTable = $sm->get('Like\Model\LikeTable');
         }
         return $this->likeTable;
     }
     
     public function getConnection()
     {
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
         
         return new ViewModel(array(
             'best' => $this->getImageTable()->get20BestPics(),
         ));
     }
 // ...
     
     public function membreAction()
     {
         $return = null;
         
         $identifiantMembre = (int) $this->params()->fromRoute('id', 0);
         
         $auth = new AuthenticationService();
         $logged = null;
         
         if ($auth->hasIdentity()){
             $session = new Container('user');
             $logged = $session->offsetGet('id');
             
         }
         
         $like = array();
         $images = $this->getImageTable()->fetchAllById($identifiantMembre);
         if($logged != null){
             foreach ($images as $image):
                 $isLike = $this->getLikeTable()->fetchCorrespondance($logged, $image->id);
                 foreach ($isLike as $isLikeTest):
                    if($isLikeTest->id != null)
                            array_push($like, 'FALSE');
                    else
                        array_push($like, 'TRUE');
                 endforeach;
             endforeach;
         }
         
         return new ViewModel(array(
             'images' => $this->getImageTable()->fetchAllById($identifiantMembre),
             'user' => $this->getUserTable()->getUser($identifiantMembre),
             'like' => $like,
         ));
     }
     
     public function addAction()
     {
         
         $logged = $this->getConnection();
         
         $form = new ImageForm();
         $form->get('submit')->setValue('Add');
         $request = $this->getRequest();
         
         if ($request->isPost()) {
             
             $image = new Image();
             $form->setInputFilter($image->getInputFilter());
             
             
             $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
             );
             
             $form->setData($post);
             
             
             if ($form->isValid()) {
                 
                 $data = $form->getData();
                 
                 //On créer la procédure pour renomer l'image
                 $filter = new \Zend\Filter\File\Rename(array(
                     "source"    => getcwd().'/public/img/BanqueImage/'.$data['lien']['name'],
                     "target"    => getcwd().'/public/img/BanqueImage',
                     "randomize" => true,
                 ));
                 
                 $adapter = new \Zend\File\Transfer\Adapter\Http(); 
                 $adapter->setDestination(getcwd().'/public/img/BanqueImage/');
                 
                 if ($adapter->receive($data['lien']['name'])) {
                     
                     //On renomme l'image pour éiter les doublons
                     $imageName = basename($filter->filter(getcwd().'/public/img/BanqueImage/'.$data['lien']['name']));
                     
                     $saveImage = array(
                           'idMembre' => $logged,
                           'lien' => $imageName
                     );
                     
                     $image->exchangeArray($saveImage);
                     $this->getImageTable()->saveImage($image);
                 }
                 
                 // Redirect to list of images
                 return $this->redirect()->toRoute('image', array('action' => 'membre', 'id' => $logged));
             }
         }
         return array('form' => $form);
     }

     public function deleteAction()
     {
         $logged = $this->getConnection();
         
         $id = (int) $this->params()->fromRoute('id', 0);
         
         if (!$id) {
             return $this->redirect()->toRoute('image');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $imgName = $request->getPost('lien');
                 $identifiantMembre = $request->getPost('idMembre');
                 
                 if($identifiantMembre != $logged): return $this->redirect()->toRoute('image'); endif;
                 
                 $this->getImageTable()->deleteImage($id);
                 
                 //On supprime l'image du dossier BanqueImage
                 $imgLinkDelete = getcwd().'/public/img/BanqueImage/'.$imgName;
                 unlink($imgLinkDelete);
             }

             // Redirect to list of images
             return $this->redirect()->toRoute('image', array('action' => 'membre', 'id' => $logged));
         }

         return array(
             'id'    => $id,
             'image' => $this->getImageTable()->getImage($id)
         );
     }
 }