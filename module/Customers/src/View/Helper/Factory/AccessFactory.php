<?php
namespace Customers\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Customers\Service\RbacManager;
use Customers\View\Helper\Access;

/**
 * This is the factory for Access view helper. Its purpose is to instantiate the helper
 * and inject dependencies into its constructor.
 */
class AccessFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {   
        $rbacManager = $container->get(RbacManager::class);
        
        return new Access($rbacManager);
    }
}


