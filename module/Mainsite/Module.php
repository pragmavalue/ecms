<?php

namespace Mainsite;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\ModuleManager\Listener;
use Zend\Mvc\ModuleRouteListener;
use Zend\Navigation;
use Zend\Session\SessionManager;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\Validator;


class Module
{
    // The "init" method is called on application start-up and 
    // allows to register an event listener.
    public function init(ModuleManager $manager)
    {
        // Get event manager.
        $eventManager = $manager->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        // Register the event listener method. 
        $sharedEventManager->attach(__NAMESPACE__, 'dispatch', 
                                    [$this, 'onDispatch'], 100);

    }

    // Event listener method.
    public function onDispatch(MvcEvent $event)
    {
        // Get controller to which the HTTP request was dispatched.
        $controller = $event->getTarget();
        // Get fully qualified class name of the controller.
        $controllerClass = get_class($controller);
        // Get module name of the controller.
        $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
           
        // Switch layout only for controllers belonging to our module.
        if ($moduleNamespace == __NAMESPACE__) {
            $viewModel = $event->getViewModel();
            #$viewModel->setTemplate('view/layout/default-layout.phtml');
        }        
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
       
        
        $eventManager = $e->getApplication()->getEventManager();
        $application = $e->getApplication();

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceManager = $application->getServiceManager();
        
        // The following line instantiates the SessionManager and automatically
        // makes the SessionManager the 'default' one to avoid passing the 
        // session manager as a dependency to other models.
        $sessionManager = $serviceManager->get(SessionManager::class);

    }
    public function getAutoloaderConfig()
    {

       
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . './src/' . __NAMESPACE__,
                    'DivixUtils' => __DIR__ . '/../../vendor/divixutils'
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return [
            
            'factories' => [
                
             ],

            'aliases' => [
                'Mainsite\Controller\Articles' => ArticlesController::class,
            ],
        ];
    }


public function getControllerConfig()
{
    return [
        'factories' => [
           
        ],
    ];
}


    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';

    }


/*    public function getServiceConfig()
    { 
    return [ 
      'factories' => [
          'ItemsFromDatabase::class => Navigation\BlogNavigationFactory::class,'
                    ],
            ];
    }
*/

public function getViewHelperConfig() {
     
      return [
     
        'factories' => [
            'AddItemsInNavigation' => function($helpers) 
            {
               $newItems = $helpers->get(ItemsFromDatabase::class);
               return new View\Helper\AddItemsInNavigation($navigation, $newItems);    
            }

        ]

    ];

}



}

class Mainsite implements EventManagerAwareInterface

{
    protected $events;

    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->events = $events;
        return $this;
    }

    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

}

return include __DIR__ . '/config/module.config.php';
