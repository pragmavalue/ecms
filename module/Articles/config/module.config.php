<?php

namespace Articles;

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
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            'articles' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/articles[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\ArticlesController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
        'articles' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/articles[/:action]',
                    'defaults' => [
                        'controller'    => Controller\ArticlesController::class,
                        'action'        => 'contakt',
                    ],
                ],
            ],                               
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\ArticlesController::class => Controller\Factory\ArticlesControllerFactory::class
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\ArticlesManager::class => Service\Factory\ArticlesManagerFactory::class,
        ],
    ],
     
     'access_filter' => [
        'controllers' => [
            Controller\ArticlesController::class => [

                ['actions'  => ['index','articles','contakt'], 'allow' => '*'],
                ['actions'  => ['articles','view', 'index', 'edit', 'admin'], 'allow' => '+articles.view'],

            ],
            Controller\BlogController::class => [

                ['actions'  => '*', 'allow' => '*'],

            ],
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

            'articles/articles/index'    => __DIR__ . '/../view/articles/index.phtml',
            'articles/articles/contakt'  => __DIR__ . '/../view/articles/contakt.phtml',
            'articles/partial/paginator' => __DIR__ . '/../view/articles/partial/paginator.phtml',
            'articles/articles/view'     => __DIR__ . '/../view/articles/view.phtml',
            
            
    
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
