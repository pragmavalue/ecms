<?php

namespace Mainsite\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use Mainsite\Service\ArticlesManager;
use Mainsite\Controller\ArticlesController;

class ArticlesControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $articlesManager = $container->get(ArticlesManager::class);
        
        return new ArticlesController($entityManager, $articlesManager);
    }
}


?>