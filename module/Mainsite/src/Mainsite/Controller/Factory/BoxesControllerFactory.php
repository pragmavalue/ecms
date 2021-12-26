<?php

namespace Mainsite\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use Mainsite\Service\BoxesManager;
use Mainsite\Controller\BoxesController;

use Doctrine\ORM\EntityManager;

class BoxesControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $boxesManager = $container->get(BoxesManager::class);
        
        return new BoxesController($entityManager, $boxesManager);
    }
}


?>