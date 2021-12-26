<?php
namespace Mainsite\Repository;

use Doctrine\ORM\EntityRepository;
use Mainsite\Entity\Articles;


/**
 * This is the custom repository class for Post entity.
 */
class ArticlesRepository extends EntityRepository
{
    /**
     * Retrieves all published posts in descending date order.
     * @return Query
     */
    public function findPublishedPosts()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('a')
            ->from(Articles::class, 'a')
            ->where('a.status = ?1')
            ->orderBy('a.date', 'DESC')
            ->setParameter('1', Articles::STATUS_PUBLISHED);

                  

        return $queryBuilder->getQuery();
    }

    /**
     * Finds all published posts having any tag.
     * @return array
     */
    public function findPostsHavingAnyTag()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('a')
            ->from(Articles::class, 'a')
            ->join('a.tags', 'a')
            ->where('a.status = ?1')
            ->orderBy('a.date', 'DESC')
            ->setParameter('1', Articles::STATUS_PUBLISHED);

        $articles = $queryBuilder->getQuery();

        return $articles;
    }

    /**
     * Finds all published posts having the given tag.
     * @param string $tagName Name of the tag.
     * @return Query
     */
    public function findPostsByTag($tagName)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('a')
            ->from(Articles::class, 'a')
            ->join('a.tags', 't')
            ->where('a.status = ?1')
            ->andWhere('t.naam = ?2')
            ->orderBy('a.date', 'DESC')
            ->setParameter('1', Articles::STATUS_PUBLISHED)
            ->setParameter('2', $tagName);

        return $queryBuilder->getQuery();
    }
}
