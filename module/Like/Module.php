<?php
 namespace Like;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;

 // Add these import statements:
 use Like\Model\Like;
 use Like\Model\LikeTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;

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
                 'Like\Model\LikeTable' =>  function($sm) {
                     $tableGateway = $sm->get('LikeTableGateway');
                     $table = new LikeTable($tableGateway);
                     return $table;
                 },
                 'LikeTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Like());
                     return new TableGateway('like', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }
 


