<?php
namespace Articles\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Articles\Entity\Articles;
use Articles\Form\ContaktForm;
use Zend\Form\Element;
use Zend\Mail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

/**
 * This is the Post controller class of the Blog Blog. 
 * This controller is used for managing posts (adding/editing/viewing/deleting).
 */
class ArticlesController extends AbstractActionController 
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager;
    
    /**
     * Articles manager.
     * @var Articles\Service\ArticlesManager 
     */
    private $articlesManager;
    
    /**
     * PHP template renderer.
     * @var Zend\View\Renderer\PhpRenderer 
     */
    private $viewRenderer;
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $articlesManager, $viewRenderer) 
    {
        $this->entityManager = $entityManager;
        $this->articlesManager = $articlesManager;
        $this->viewRenderer = $viewRenderer;

    }
    
    /**
     * This action displays the "New Post" page. The page contains a form allowing
     * to enter post title, content and tags. When the user clicks the Submit button,
     * a new Post entity will be created.
     */
    public function addAction() 
    {     
        // Create the form.
        $form = new ArticlesForm();
        
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
                return $this->redirect()->toRoute('Articles');
            }
        }
        
        // Render the view template.
        return new ViewModel([
            'form' => $form
        ]);
    }    
    
    /**
     * This action displays the "View Post" page allowing to see the post title
     * and content. The page also contains a form allowing
     * to add a comment to post. 
     */
    public function viewAction() 
    {       
        
    if (!$this->access('user.manage')) {
            $this->getResponse()->setStatusCode(401);
            return;
        }   

        $postId = (int)$this->params()->fromRoute('id', -1);
        
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
        
        // Render the view template.
        return new ViewModel([
            'articles' => $articles,
            'articlesManager' => $this->articlesManager

        ]);

    }  
    
    /**
     * This action displays the page allowing to edit a post.
     */
    public function editAction() 
    {
        // Create form.
        $form = new PostForm();
        
        // Get post ID.
        $postId = (int)$this->params()->fromRoute('id', -1);
        
        // Validate input parameter
        if ($postId<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find the existing post in the database.
        $post = $this->entityManager->getRepository(Articles::class)
                ->findOneById($postId);        
        if ($post == null) {
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
                $this->postManager->updatePost($post, $data);
                
                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('articles', ['action'=>'admin']);
            }
        } else {
            $data = [
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'tags' => $this->postManager->convertTagsToString($post),
                'status' => $post->getStatus()
            ];
            
            $form->setData($data);
        }
        
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'post' => $post
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
        
        $post = $this->entityManager->getRepository(Articles::class)
                ->findOneById($postId);        
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        }        
        
        $this->postManager->removePost($post);
        
        // Redirect the user to "admin" page.
        return $this->redirect()->toRoute('artiles', ['action'=>'admin']);        
                
    }
    
    /**
     * This "admin" action displays the Manage Posts page. This page contains
     * the list of posts with an ability to edit/delete any post.
     */
    public function adminAction()
    {
        // Get recent posts
        $posts = $this->entityManager->getRepository(Articles::class)
                ->findBy([], ['dateCreated'=>'DESC']);
        
        // Render the view template
        return new ViewModel([
            'posts' => $posts,
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
    public function contaktAction()
    {
        // Create the form.
        $form = new ContaktForm();
        
        // Check whether this post is a POST request.
        if($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Fill form with data.
            $form->setData($data);

            if($form->isValid()) {
                                
                // Get validated form data.
                $data = $form->getData();
                               
                // Redirect the user again to "view" page.
                // Send a mail message

                $subject = 'Informacja kontaktowa - pragmavalue.com';

                
                $title = $data['title'];
                $autor = $data['author'];
                $email = $data['email'];
               
                $mailcontent = (string) $data['content'];
                
                // Produce HTML

                $bodyHtml = $this->viewRenderer->render(realpath('./modules/Articles/view/email/contact-email'),
                [
                    'mailcontent' => $mailcontent,
                    'title'       => $title,
                    'autor'       => $autor,
                    'email'       => $email,

                ]);
                

                $html = new MimePart($bodyHtml);
                $html->type = "text/html";

                $body = new MimeMessage();
                $body->addPart($html);

                $mail = new Mail\Message();
                $mail->setEncoding('UTF-8');
                $mail->setBody($body);
                $mail->setFrom($email, $subject);
                $mail->addTo('admin@pragmavalue.com');
                $mail->setSubject($subject);

                // Setup SMTP transport
                $transport = new SmtpTransport();
                $options   = new SmtpOptions
                ([
                  'connection_class'  => 'login',
                  'connectionConfig' => [
                        'username' => '***',
                        'password' => '***',
                        
                    ],
                ]);

                $transport->setOptions($options);
                $transport->send($mail);
               
                return $this->redirect()->toRoute('users', ['action'=>'message', 'id'=>'sent']);  

            }

        }
        return new ViewModel([
            'form' => $form
        ]);
    }
}
