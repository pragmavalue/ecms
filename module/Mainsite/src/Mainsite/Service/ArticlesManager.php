<?php
namespace Mainsite\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

use Mainsite\Entity\Articles;
use Mainsite\Entity\Tag;
use Mainsite\Entity\Counter;
use Mainsite\Entity\Boxes;

use Mainsite\Repository\ArticlesRepository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;

use Zend\Filter\StaticFilter;

/**
 * The articlesManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class ArticlesManager
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
    public function addNewPost($data) 
    {
        // Create new Post entity.
        $post = new Articles();
        $post->setTitle($data['title']);
        $post->setNaam($data['naam']);
        $post->setContent($data['content']);
        $post->setNavigation($data['navigation']);
        $post->setOrder($data['order']);
        $post->setAutor($data['autor']);
        $post->setStatus($data['status']);
        $currentDate = date('Y-m-d H:i:s');
        $post->setDateCreated($currentDate);        
        
        // Add the entity to entity manager.
        $this->entityManager->persist($post);
        
        // Add tags to post
        $this->addTagsToPost($data['tags'], $post);
        
        // Apply changes to database.
        $this->entityManager->flush();
    }
    
    /**
     * This method allows to update data of a single post.
     */
    public function updatePost($articles, $data) 
    {
        $articles->setTitle($data['title']);
        $articles->setContent($data['content']);
        $articles->setStatus($data['status']);
        
        // Add tags to post
        $this->addTagsToPost($data['tags'], $articles);
        
        // Apply changes to database.
        $this->entityManager->flush();
    }

    /**
     * Adds/updates tags in the given post.
     */
    private function addTagsToPost($tagsStr, $articles) 
    {
        // Remove tag associations (if any)
        $tags = $articles->getTags();
        foreach ($tags as $tag) {            
            $articles->removeTagAssociation($tag);
        }
        
        // Add tags to post
        $tags = explode(',', $tagsStr);
        foreach ($tags as $tagNaam) {
            
            $tagNaam = StaticFilter::execute($tagNaam, 'StringTrim');
            if (empty($tagName)) {
                continue; 
            }
            
            $tag = $this->entityManager->getRepository(Tag::class)
                    ->findOneByName($tagNaam);
            if ($tag == null)
                $tag = new Tag();
            
            $tag->setNaam($tagNaam);
            $tag->addArticles($articles);
            
            $this->entityManager->persist($tag);
            
            $articles->addTag($tag);
        }
    }    
    
    /**
     * Returns status as a string.
     */
    public function getPostStatusAsString($articles) 
    {
        switch ($articles->getStatus()) {
            case Articles::STATUS_DRAFT: return 'Szkic';
            case Articles::STATUS_PUBLISHED: return 'Opublikowany';
        }
        
        return 'Unknown';
    }
    
    /**
     * Converts tags of the given post to comma separated list (string).
     */
    public function convertTagsToString($articles) 
    {
        $tags = $articles->getTags();
        $tagCount = count($tags);
        $tagsStr = '';
        $i = 0;
        foreach ($tags as $tag) {
            $i ++;
            $tagsStr .= $tag->getNaam();
            if ($i < $tagCount) 
                $tagsStr .= ', ';
        }
        
        return $tagsStr;
    }    

    
    /* Removes post and all associated comments.
    */
    public function removePost($articles) 
    {
        
        // Remove tag associations (if any)
        $tags = $articles->getTags();
        foreach ($tags as $tag) {
            
            $articles->removeTagAssociation($tag);
        }
        
        $this->entityManager->remove($post);
        
        $this->entityManager->flush();
    }
    
    
     /* Calculates frequencies of tag usage.
     */
    public function getTagCloud()
    {
        $tagCloud = [];
                
        $articles[] = $this->entityManager->getRepository(Articles::class)
                    ->findPostsHavingAnyTag();

        $totalarticlesCount = count($articles);
        
        $tags = $this->entityManager->getRepository(Tag::class)
                ->findAll();
        foreach ($tags as $tag) {
            
            $articlesByTag = $this->entityManager->getRepository(Articles::class)
                    ->findPostsByTag($tag->getNaam())->getResult();
            
            $articlesCount = count($articlesByTag);
            if ($articlesCount > 0) {
                $tagCloud[$tag->getNaam()] = $articlesCount;
            }
        }
        
        $normalizedTagCloud = [];
        
        // Normalize
        foreach ($tagCloud as $naam=>$articlesCount) {
            $normalizedTagCloud[$naam] =  $articlesCount/$totalarticlesCount;
        }
        
        return $normalizedTagCloud;
    }
}



