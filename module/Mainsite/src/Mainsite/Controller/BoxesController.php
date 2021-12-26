<?php
namespace Mainsite\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

use Mainsite\Entity\Boxes;

use Mainsite\Repository\CounterManager;
use Mainsite\Repository\ArticlesManager;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;



class BoxesController extends AbstractActionController 
{

    private $entityManager;

    /**
     * Post manager.
     * @var Mainsite\Service\ArticlesManager
     */
    private $boxesManager;
    
    public function __construct($entityManager, $boxesManager)
    {
        $this->entityManager = $entityManager;
        $this->BoxesManager = $boxesManager;
    }
    

    public function viewAction() 
    {
        
        $id = 1;

        $post = $this->entityManager->getRepository(Boxes::class)
                ->findOneById($id);


        return new view(['boxes' => $post])
    }
    
    
}

?>