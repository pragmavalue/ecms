<?php
namespace Mainsite\Repository;

use Doctrine\ORM\EntityRepository;
use Mainsite\Entity\Boxes;

/**
 * This is the custom repository class for User entity.
 */
class BoxesRepository extends EntityRepository
{
    /**
     * Retrieves all users in descending dateCreated order.
     * @return Query
     */
    public function BoxesValue()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select("b")
            ->from(Boxes::class, 'b')
            ->where('b.id = ?1');
            
        return $queryBuilder->getQuery();
    }
    public function counterValue()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select("c")
            ->from(Counter::class, 'c')
            ->where('c.id = ?1');
            
        return $queryBuilder->getQuery();
    }
}