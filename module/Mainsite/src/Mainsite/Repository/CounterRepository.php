<?php
namespace Mainsite\Repository;

use Doctrine\ORM\EntityRepository;
use Mainsite\Entity\Counter;

/**
 * This is the custom repository class for User entity.
 */
class CounterRepository extends EntityRepository
{
    /**
     * Retrieves all users in descending dateCreated order.
     * @return Query
     */
    public function CounterValue()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select(*.p)
            ->from(Counter::class, 'p')
            ->where('p.value = ?1');

        return $queryBuilder->getQuery();
    }
}