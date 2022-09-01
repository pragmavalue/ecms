<?php
namespace Articles\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Articles\Service\ArticlesManager;
use Articles\Controller\ArticlesController;
use Doctrine\ORM;

/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller.
 */
class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $articlesManager = $container->get(ArticlesManager::class);
        
        // Instantiate the controller and inject dependencies
        return new IndexController($entityManager, $articlesManager);
    }
}




