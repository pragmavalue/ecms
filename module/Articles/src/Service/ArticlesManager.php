<?php
namespace Articles\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Articles\Entity\Articles;
use Articles\Entity\Tag;
use Zend\Filter\StaticFilter;

/**
 * The PostManager service is responsible for adding new posts, updating existing
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
    public function addNewArticle($data) 
    {
        // Create new Post entity.
        $article = new Articles();
        $article->setTitle($data['title']);
        $article->setContent($data['content']);
        $article->setStatus($data['status']);
        $currentDate = date('Y-m-d H:i:s');
        $article->setDateCreated($currentDate);        
        
        // Add the entity to entity manager.
        $this->entityManager->persist($article);
        
        // Add tags to article
        $this->addTagsToArticle($data['tags'], $post);
        
        // Apply changes to database.
        $this->entityManager->flush();
    }
    
    /**
     * This method allows to update data of a single article.
     */
    public function updateArticle($article, $data) 
    {
        $article->setTitle($data['title']);
        $article->setContent($data['content']);
        $article->setStatus($data['status']);
        
        // Add tags to article
        $this->addTagsToArticle($data['tags'], $article);
        
        // Apply changes to database.
        $this->entityManager->flush();
    }

    /**
     * Adds/updates tags in the given article.
     
    private function addTagsToArticle($tagsStr, $article) 
    {
        // Remove tag associations (if any)
        $tags = $article->getTags();
        foreach ($tags as $tag) {            
            $article->removeTagAssociation($tag);
        }
        
        // Add tags to article
        $tags = explode(',', $tagsStr);
        foreach ($tags as $tagNaam) {
            
            $tagNaam = StaticFilter::execute($tagNaam, 'StringTrim');
            if (empty($tagNaam)) {
                continue; 
            }
            
            $tag = $this->entityManager->getRepository(Tag::class)
                    ->findOneByNaam($tagNaam);
            if ($tag == null)
                $tag = new Tag();
            
            $tag->setNaam($tagNaam);
            $tag->addArticle($article);
            
            $this->entityManager->persist($tag);
            
            $article->addTag($tag);
        }
    }    
    
    /**
     * Returns status as a string.
     */
    public function getarticleStatusAsString($article) 
    {
        switch ($article->getStatus()) {
            case Articles::STATUS_DRAFT: return 'Szkic';
            case Articles::STATUS_PUBLISHED: return 'Opublikowany';
        }
        
        return 'Unknown';
    }
    
    /**
     * Converts tags of the given article to comma separated list (string).
    
    public function convertTagsToString($article) 
    {
        $tags = $article->getTags();
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

    /**
     * Returns count of comments for given article as properly formatted string.
    
    public function getCommentCountStr($article)
    {
        $commentCount = count($article->getComments());
        if ($commentCount == 0)
            return 'No comments';
        else if ($commentCount == 1) 
            return '1 comment';
        else
            return $commentCount . ' comments';
    }


    /**
     * This method adds a new comment to article.
    
    public function addCommentToArticle($article, $data) 
    {
        // Create new Comment entity.
        $comment = new Comment();
        $comment->setArticle($article);
        $comment->setAuthor($data['author']);
        $comment->setContent($data['comment']);        
        $currentDate = date('Y-m-d H:i:s');
        $comment->setDateCreated($currentDate);

        // Add the entity to entity manager.
        $this->entityManager->persist($comment);

        // Apply changes.
        $this->entityManager->flush();
    }
    
    /**
     * Removes article and all associated comments.
     */
    public function removeArticle($article) 
    {
        // Remove associated comments
        $comments = $article->getComments();
        foreach ($comments as $comment) {
            $this->entityManager->remove($comment);
        }
        
        // Remove tag associations (if any)
        $tags = $article->getTags();
        foreach ($tags as $tag) {
            
            $article->removeTagAssociation($tag);
        }
        
        $this->entityManager->remove($article);
        
        $this->entityManager->flush();
    }
    
    /**
     * Calculates frequencies of tag usage.
     
    public function getTagCloud()
    {
        $tagCloud = [];
                
        $articles = $this->entityManager->getRepository(Articles::class)
                    ->findPostsHavingAnyTag();
        $totalArticleCount = count($articles);
        
        $tags = $this->entityManager->getRepository(Tag::class)
                ->findAll();
        foreach ($tags as $tag) {
            
            $ArticlesByTag = $this->entityManager->getRepository(Articles::class)
                    ->findPostsByTag($tag->getNaam())->getResult();
            
            $articleCount = count($articlesByTag);
            if ($articleCount > 0) {
                $tagCloud[$tag->getNaam()] = $articleCount;
            }
        }
        
        $normalizedTagCloud = [];
        
        // Normalize
        foreach ($tagCloud as $naam=>$articleCount) {
            $normalizedTagCloud[$naam] =  $articleCount/$totalarticleCount;
        }
        
        return $normalizedTagCloud;
    }
*/
}



