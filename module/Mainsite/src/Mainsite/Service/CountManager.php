<?php
namespace Mainsite\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Mainsite\Entity\Counter;
use Zend\Filter\StaticFilter;

/**
 * The articlesManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class CounterManager
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager;
     */
    private $entityManager;
    
    /**
     * Constructor.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * This method adds a new post.
     */
    public function updatePost($post, $data) 
    {
        
        $post->setCounter($data['counter']);
        
                        
        // Apply changes to database.
        $this->entityManager->flush();
    }

    
}



