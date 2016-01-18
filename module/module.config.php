<?php
     return array(
     'controllers' => array(
         'invokables' => array(
             'Image\Controller\Image' => 'Image\Controller\ImageController',
             'User\Controller\User' => 'User\Controller\UserController',
             'Like\Controller\Like' => 'Like\Controller\LikeController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'image' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/image[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Image\Controller\Image',
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
             'like' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/like[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Like\Controller\Like',
                        'action' => 'index'
                    ),
                ),
            ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'image' => __DIR__ . '/../view',
         ),
     ),
 );
