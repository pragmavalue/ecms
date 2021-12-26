<?php

namespace Mainsite;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\Router\Http\Regex;
use Zend\Router\Http\SimpleRouteStack;
use Zend\ServiceManager\Factory\InvokableFactory;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

use Zend\View\HelperPluginManager;


return [
     
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                            'constraints' => [
                                'action'      => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'          => '[0-9]+',
                                'controller'  => '[a-zA-Z][a-zA-Z0-9_-]*',

                                 ],

                    'defaults' => [
                        
                        'controller'    =>  Mainsite\Controller\ArticlesController::class,
                        'action'        => 'index',

                        ],
                    ],
                ],
            'Blog' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/blog[/:action]',
                    'defaults' => [
                        'controller'    => \Blog\Controller\BlogController::class,
                        'action'        => 'index',
                    ],
                ],
            ],


                'articles' => [
                    'type'    => Segment::class,
                    'options' => [
                        'route'    => '/articles[/:action][/:id]',
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[0-9]*'
                        ],
                        'defaults' => [
                            'controller' => Mainsite\Controller\ArticlesController::class,
                            'action' => 'view',

                    ],
                ],
            ],
            

                'login' => [
                    'type' => Literal::class,
                    'options' => [
                        'route'    => '/login',
                        'defaults' => [
                            'controller' => \Customers\Controller\AuthController::class,
                            'action'     => 'login',
                    ],
                ],
            ],
    
  


                    'sitemap' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/sitemap.xml',
                            'defaults' => [
                                'controller' => Controller\SitemapController::class,
                                'action'     => 'index',
                    ],
                ],
            ],

    ],

    ],
        
    'controllers' => [
        'factories' => [

            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Mainsite\Controller\ArticlesController::class => Controller\Factory\ArticlesControllerFactory::class,
            Mainsite\Controller\BoxesController::class => Controller\Factory\BoxesControllerFactory::class,
            Blog\Controller\BlogController::class => Controller\BlogControllerFactory::class,
            Customers\Controller\AuthController::class => Controller\Factory\AuthControllerFactory::class,
        ],
    
         'aliases' => [

             'index' => Mainsite\Controller\IndexController::class,

    ],
  
        'classes' => [
            
            'Mainsite\Controller\Index'         => Mainsite\Controller\IndexController::class,




    ],


    ],
    'controller_plugins' => [
 

        'factories' => [
            


        ],
        'aliases' => [
            #'debug' => 'DivixUtils\Logs\Debugs'
        ]
    ],
        
    'service_manager' => [
        'factories' => [


             Service\ArticlesManager::class => Service\Factory\ArticlesManagerFactory::class,

            #Service\RbacAssertionManager::class => Service\Factory\RbacAssertionManagerFactory::class,

    ],

        /*'services' [

            'application-log-dir'      => realpath(__DIR__ . '/../../../data/logs'),
            'application-log-filename' => 'message.log',
        ],*/
    ],
    'view_helpers' => [
        'factories' => [

            View\Helper\HtmlRender::class => View\Helper\Factory\HtmlRenderFactory::class,
            #View\Helper\Menu::class => View\Helper\Factory\MenuFactory::class,
            View\Helper\Breadcrumbs::class => InvokableFactory::class,
            
        ],
        'aliases' => [
            #'mainMenu' => View\Helper\Menu::class,
            'pageBreadcrumbs' => View\Helper\Breadcrumbs::class,
              #'index' => Controller\ArticlesController::class,
        
        ],
    ],

    'view_manager' => [

        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_path_stack' => [
            'mainsite' => __DIR__ . '/../view'

                                ],
        'template_map' => [
            'layout/layout'             => __DIR__ . '/../view/layout/default-layout.phtml',
            'layout/custom_layout'      => __DIR__ . '/../view/layout/custom-layout.phtml',
            'error/404'                 => __DIR__ . '/../view/error/404.phtml',
            'error/index'               => __DIR__ . '/../view/error/index.phtml',
            'articles/admin'            => __DIR__ . '/../view/mainsite/articles/admin.phtml',
            'articles/edit'             => __DIR__ . '/../view/mainsite/articles/edit.phtml',
            'mainsite/articles/index'   => __DIR__ . '/../view/mainsite/index/index.phtml',
    	                   ],
        'cache' => [
            'adapter' => [
                'name' => 'Filesystem',
                'options' => [
                    'cache_dir' => 'data/cache',
                    'ttl' => '86400', //24h
                ],
            ],

        'base_path' =>  __DIR__  . '/ecms/public/',
        'base_url'  =>  __DIR__  . '/ecms/',

        ],

        'strategies' => [
                'ViewJsonStrategy',
        ],

    ],


     'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/'.__NAMESPACE__.'/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                        ]
                      ]
                ],
         ],


];


