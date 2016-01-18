<?php
     return array(
     'controllers' => array(
         'invokables' => array(
             'Like\Controller\Like' => 'Like\Controller\LikeController',
             'User\Controller\User' => 'User\Controller\UserController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'like' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/like[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[a-zA-Z0-9]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Like\Controller\Like',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'user' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id_event' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\User',
                        'action' => 'index'
                    ),
                ),
            ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'like' => __DIR__ . '/../view',
         ),
     ),
 );
