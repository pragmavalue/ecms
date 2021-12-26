<?php
namespace Mainsite\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Mainsite\Service\ArticlesManager;

/**
 * This is the factory for ArticlesManager. Its purpose is to instantiate the
 * service.
 */
class ArticlesManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');


        // Instantiate the service and inject dependencies
        return new ArticlesManager($entityManager);
    }
}




