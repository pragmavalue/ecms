<?php
namespace Articles\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Articles\Entity\Articles;

/**
 * This is the main controller class of the Blog Blog. The 
 * controller class is used to receive user input,  
 * pass the data to the models and pass the results returned by models to the 
 * view for rendering.
 */
class IndexController extends AbstractActionController 
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager;
    
    /**
     * Post manager.
     * @var Articles\Service\articlesManager 
     */
    private $articlesManager;
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $articlesManager) 
    {
        $this->entityManager = $entityManager;
        $this->articlesManager = $articlesManager;
    }
    
    /**
     * This is the default "index" action of the controller. It displays the 
     * Recent Posts page containing the recent blog posts.
     */
    public function indexAction() 
    {
        $page = $this->params()->fromQuery('page', 1);
        $tagFilter = $this->params()->fromQuery('tag', null);
        
        if ($tagFilter) {
         
            // Filter posts by tag
            $query = $this->entityManager->getRepository(Articles::class)
                    ->findPostsByTag($tagFilter);
            
        } else {
            // Get recent posts
            $query = $this->entityManager->getRepository(Articles::class)
                    ->findPublishedPosts();
        }
        
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(3);        
        $paginator->setCurrentPageNumber($page);
                       
        // Get popular tags.
        $tagCloud = $this->postManager->getTagCloud();
        
        // Render the view template.
        return new ViewModel([
            'posts' => $paginator,
            'articlesManager' => $this->articlesManager,
            'tagCloud' => $tagCloud
        ]);
    }
    
    /**
     * This action displays the About page.
     */
    public function aboutAction() 
    {   
        $appName = 'Blog';
        $appDescription = 'A simple blog Blog for the Using Zend Framework 3 book';
        
        return new ViewModel([
            'appName' => $appName,
            'appDescription' => $appDescription
        ]);
    }
}
