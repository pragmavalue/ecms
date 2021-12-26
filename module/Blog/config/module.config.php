<?php

namespace Blog;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\Router\Http\Regex;
use Zend\ServiceManager\Factory\InvokableFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\BlogController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            'posts' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/posts[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\PostController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
                                             
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\BlogController::class => Controller\Factory\BlogControllerFactory::class,
            Controller\PostController::class => Controller\Factory\PostControllerFactory::class
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\PostManager::class => Service\Factory\PostManagerFactory::class,
        ],
    ],
    // The following registers our custom view 
    // helper classes in view plugin manager.
    'view_helpers' => [
        'factories' => [
          //  View\Helper\Menu::class => InvokableFactory::class,
            View\Helper\Breadcrumbs::class => InvokableFactory::class,
        ],
        'aliases' => [
          //  'mainMenu' => View\Helper\Menu::class,
            'pageBreadcrumbs' => View\Helper\Breadcrumbs::class,
        ],
    ],

    'view_manager' => [
        
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        
        'template_map' => [

            'blog/blog/index' => __DIR__ . '/../view/blog/index/index.phtml',
            'blog/partial/paginator' => __DIR__ . '/../view/blog/partial/paginator.phtml',
            'blog/post/view' => __DIR__ . '/../view/blog/post/view.phtml',
            'blog/post/admin' => __DIR__ . '/../view/blog/post/admin.phtml',
            'blog/post/edit' => __DIR__ . '/../view/blog/post/edit.phtml',
            'blog/post/add' => __DIR__ . '/../view/blog/post/add.phtml',

            
    
        'template_path_stack' => [
            __DIR__ . '/../view',
        ]

    ]

    ],


    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
];
