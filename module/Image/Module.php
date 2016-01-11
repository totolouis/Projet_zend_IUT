<?php
 namespace Image;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;

 // Add these import statements:
 use Image\Model\Image;
 use Image\Model\ImageTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\Mvc\ModuleRouteListener;
 use Zend\Mvc\MvcEvent;

 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
     
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Image\Model\ImageTable' =>  function($sm) {
                     $tableGateway = $sm->get('ImageTableGateway');
                     $table = new ImageTable($tableGateway);
                     return $table;
                 },
                 'ImageTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Image());
                     return new TableGateway('image', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }
 


