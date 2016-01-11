<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;


use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
       /*$eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);*/
        
       $eventManager = $e->getApplication()->getEventManager();
       $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'Auth'),1);
    }
    
    public function Auth($e){
        //----------Auth Logic-----------
        $auth = new AuthenticationService();

        if (!$auth->hasIdentity()){
            //si non connecté
            $uri = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            if($uri != "zf2.localhost/ZendSkeletonApplication/public/user/signin" AND $uri != "zf2.localhost/ZendSkeletonApplication/public/user/signup"){
                //$moduleRouteListener->attach(MvcEvent::EVENT_DISPATCH, array($this, 'user'));
                //$moduleRouteListener->plugin('redirect')->toRoute('user');
                $url = "zf2.localhost/ZendSkeletonApplication/public/user/signin";
                
                $url = $e->getRouter()->assemble(array('action' => 'signin'), array('name' => 'user'));

                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                $response->sendHeaders();
                exit;
            }
        }
        //------------------------------
        
        
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
