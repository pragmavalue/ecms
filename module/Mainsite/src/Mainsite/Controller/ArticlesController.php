<?php
namespace Mainsite\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Mainsite\Entity\Articles;
use Mainsite\Entity\Counter;
use Mainsite\Entity\Boxes;
use Mainsite\Entity\Tag;

use Mainsite\Form\ArticleForm;

use Mainsite\Repository\CounterManager;
use Mainsite\Repository\ArticlesManager;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;


class ArticlesController extends AbstractActionController
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
    public function __construct($entityManager, $articlesManager)
    {
        $this->entityManager = $entityManager;
        $this->articlesManager = $articlesManager;
    }

    /**
     * This action displays the "New Post" page. The page contains a form allowing
     * to enter post title, content and tags. When the user clicks the Submit button,
     * a new Post entity will be created.
     */
    public function addAction()
    {
        // Create the form.
        $form = new ArticleForm();

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {

                // Get validated form data.
                $data = $form->getData();

                // Use post manager service to add new post to database.
                $this->articlesManager->addNewPost($data);

                // Redirect the user to "index" page.
                return $this->redirect()->toRoute('articles');
            }
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form
        ]);
    }

    public function viewAction()
    {
        $postId = (int)$this->params()->fromRoute('id', 2);

        // Validate input parameter
        if ($postId<0) {
            
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find the post by ID
        $articles = $this->entityManager->getRepository(Articles::class)
            ->findOneById($postId);


        if ($articles == null) {
            
            $this->getResponse()->setStatusCode(404);
            return;
        }
       
        $counter = new Counter;
        $counter = $this->entityManager->getRepository(Counter::class)
            ->counterValue();


        $form = null;

        //* Check whether this post is a POST request.
        if($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            if($form->isValid()) {

                // Get validated form data.
                $data = $form->getData();

                // Redirect the user again to "view" page.
                return $this->redirect()->toRoute('articles', ['action'=>'view', 'id'=>$postId]);
            }
        }

        $post = $this->entityManager->getRepository(Boxes::class)
                ->findOneById('1');

        $tagCloud = $this->articlesManager->getTagCloud();

        // Render the view template.
        return new ViewModel([
            'articles' => $articles,
            'form' => $form,
            'articlesManager' => $this->articlesManager,
            'counter' => $counter,
            'boxes' => $post
        ]);
    }

    /**
     * This action displays the page allowing to edit a post.
     */
    public function editAction()
    {
        // Create form.
        $form = new ArticleForm();

        // Get post ID.
        $postId = (int)$this->params()->fromRoute('id', -1);

        // Validate input parameter
        if ($postId<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find the existing post in the database.
        $articles = $this->entityManager->getRepository(Articles::class)
            ->findOneById($postId);
        if ($articles == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {

                // Get validated form data.
                $data = $form->getData();

                // Use post manager service update existing post.
                $this->articlesManager->updatePost($articles, $data);

                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('articles', ['action'=>'admin']);
            }
        } else {
            $data = [
                'title' => $articles->getTitle(),
                'content' => $articles->getContent(),
                'tags' => $this->articlesManager->convertTagsToString($articles),
                'status' => $articles->getStatus()
            ];

            $form->setData($data);
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'articles' => $articles
        ]);
    }

    /**
     * This "delete" action deletes the given post.
     */
    public function deleteAction()
    {
        $postId = (int)$this->params()->fromRoute('id', -1);

        // Validate input parameter
        if ($postId<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $articles = $this->entityManager->getRepository(Articles::class)
            ->findOneById($postId);
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->articlesManager->removePost($articles);

        // Redirect the user to "admin" page.
        return $this->redirect()->toRoute('articles', ['action'=>'admin']);

    }

    /**
     * This "admin" action displays the Manage Posts page. This page contains
     * the list of posts with an ability to edit/delete any post.
     */
    public function adminAction()
    {
        // Get recent posts
        $articles = $this->entityManager->getRepository(Articles::class)
            ->findBy([], ['date'=>'DESC']);

        // Render the view template
        return new ViewModel([
            'articles' => $articles,
            'articlesManager' => $this->articlesManager
        ]);
    }

     public function settingsAction()
    {
        $id = $this->params()->fromRoute('id');
        
        if ($id!=null) {
            $user = $this->entityManager->getRepository(User::class)
                    ->find($id);
        } else {
            $user = $this->currentUser();
        }
        
        if ($user==null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        if (!$this->access('profile.any.view') && 
            !$this->access('profile.own.view', ['user'=>$user])) {
            return $this->redirect()->toRoute('not-authorized');
        }
        
        return new ViewModel([
            'user' => $user
        ]);
    } 
    
}

