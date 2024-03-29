<?php
namespace Customers\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Customers\View\Helper\CurrentUser;

class CurrentUserFactory
{
    public function __invoke(ContainerInterface $container)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
                        
        return new CurrentUser($entityManager, $authService);
    }
}
