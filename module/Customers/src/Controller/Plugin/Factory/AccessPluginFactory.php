<?php
namespace Customers\Controller\Plugin\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Customers\Service\RbacManager;
use Customers\Controller\Plugin\AccessPlugin;

/**
 * This is the factory for AccessPlugin. Its purpose is to instantiate the plugin
 * and inject dependencies into its constructor.
 */
class AccessPluginFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {   
        $rbacManager = $container->get(RbacManager::class);
        
        return new AccessPlugin($rbacManager);
    }
}


