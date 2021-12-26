<?php
namespace Mainsite\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Doctrine\ORM\EntityManager;
use Zend\Paginator\Paginator;

use Mainsite\Entity\Articles;
use Mainsite\Repository\ArticlesManager;


/**
 * This is the main controller class of the Blog application. The 
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
     * @var Mainsite\Service\ArticlesManager 
     */
    private $articlesManager;
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    /**
     * IndexController constructor.
     * @param $entityManager
     */

    public function __construct(EntityManager $entityManager, ArticlesManager $articlesManager)
    {
        $this->entityManager = $entityManager;
        $this->articlesManager = $articlesManager;

    }
    

    public function indexAction() 
    {
     
              
        $article = $this->params()->fromQuery('article', 1);
        $wynik = $this->entityManager->getRepository(Articles::class)->find($article);

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

        
        $tagCloud = $this->articlesManager->getTagCloud();

        // Render the view template.
        return new ViewModel([
            'wynik' => $wynik,
            'tagCloud' => $tagCloud
         
        ]);

    }
    
    /**
     * This action displays the About page.
     */
    public function aboutAction() 
    {   
        $appName = 'ED CMS';
        $appDescription = 'A simple blog application for the Using Zend Framework 3 book';
        
        return new ViewModel([
            'appName' => $appName,
            'appDescription' => $appDescription
        ]);
    }
}
?>
