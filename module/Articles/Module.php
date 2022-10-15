<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonBlog for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Articles;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\ModuleManager\Listener;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Navigation;
use Zend\Session\SessionManager;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\Validator;

use Articles\Entity\Articles;


class Module
{
    
public function init(ModuleManager $manager)
    {        
        $eventManager = $manager->getEventManager();    
        $sharedEventManager = $eventManager->getSharedManager();
        $sharedEventManager->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 100);
        $sharedEventManager->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'onDispatchError'], 110);
    }

public function onBootstrap(MvcEvent $e)
    {
        
        $eventManager = $e->getApplication()->getEventManager();
        $application = $e->getApplication();

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceManager = $application->getServiceManager();
        
        $sessionManager = $serviceManager->get(SessionManager::class);

        $sharedEventManager = $e->getParam('Articles');
        		
        $sharedEventManager = $eventManager->getSharedManager();
        // Register the event listener method. 
        $sharedEventManager->attach(__NAMESPACE__, 'dispatch', 
                                    [$this, 'onDispatch'], 100);
    }

public function onDispatch(MvcEvent $event)
    {
        // Get controller to which the HTTP request was dispatched.
        $controller = $event->getTarget();
        // Get fully qualified class name of the controller.
        $controllerClass = get_class($controller);
        // Get module name of the controller.
        $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
           
     	$matches    = $event->getRouteMatch();
        $controller = $matches->getParam('Articles');
        if (false === strpos($controller, __NAMESPACE__)) {
         
            return;
        }

            // Switch layout only for controllers belonging to our module.
        if ($moduleNamespace == __NAMESPACE__) {
            $viewModel = $event->getViewModel();
            $app = $event->getTarget();
            $locator = $app->getServiceManager();
            $viewModel = $locator->get('Zend\View\View');
            $viewModel->setTemplate('layout/admin-layout');
        }        
    }

public function onDispatchError(MvcEvent $event)
    {

        // Get the exception information.
        $exception = $event->getParam('exception');
        if ($exception!=null) {
            $exceptionName = $exception->getMessage();
            $file = $exception->getFile();
            $line = $exception->getLine();
            $stackTrace = $exception->getTraceAsString();
        }
        
        $errorMessage = $event->getError();
        $controllerName = $event->getController();

        // Prepare email message.
        $to = 'admin@pragmavalue.com';
        $subject = 'ECms error';

        $body = '';
        if(isset($_SERVER['REQUEST_URI'])) {
            $body .= "Request URI: " . $_SERVER['REQUEST_URI'] . "\n\n";
        }
        $body .= "Controller: $controllerName\n";
        $body .= "Error message: $errorMessage\n";
        if ($exception!=null) {
            $body .= "Exception: $exceptionName\n";
            $body .= "File: $file\n";
            $body .= "Line: $line\n";
            $body .= "Stack trace:\n\n" . $stackTrace;
        }

        $body = str_replace("\n", "<br>", $body);

        // Send an email about the error.
        mail($to, $subject, $body);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../../vendor/composer/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'Articles'    => __DIR__ . '/src/' . 'Articles', //This line
                    'Customers'   => __DIR__ . '/src/' //This line
                ),
            ),
        );
    }
}

