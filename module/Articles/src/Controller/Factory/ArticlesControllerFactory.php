<?php
namespace Articles\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Articles\Service\ArticlesManager;
use Articles\Controller\ArticlesController;

/**
 * This is the factory for PostController. Its purpose is to instantiate the
 * controller.
 */
class ArticlesControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $articlesManager = $container->get(ArticlesManager::class);
        
        // Instantiate the controller and inject dependencies
        return new ArticlesController($entityManager, $articlesManager);
    }
}


