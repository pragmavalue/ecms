<?php
namespace Mainsite\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Mainsite\Sevice\ArticlesManager;


/**
 * This class represents a single post in a blog.
 * @ORM\Entity(repositoryClass="Mainsite\Repository\ArticlesRepository")
 * @ORM\Table(name="articles", options={"collate":"utf8mb4_unicode_ci", "charset":"utf-8"})
 */
class Articles
{
    // Post status constants.
    const STATUS_DRAFT       = 1; // Draft.
    const STATUS_PUBLISHED   = 2; // Published.

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** 
     * @ORM\Column(name="title")  
     */
    protected $title;

    /** 
     * @ORM\Column(name="naam")  
     */
    protected $naam;

    /** 
     * @ORM\Column(name="content")  
     */
    
    protected $content;

    /** 
     * @ORM\Column(name="navigation")  
     */
    protected $navigation;

    /** 
     * @ORM\Column(name="order")  
     */
    protected $order;

    /**
     * @ORM\Column(name="autor")  
     */

    protected $autor;

    /**
     * @ORM\Column(name="status")
     */

    protected $status;

    /**
     * @ORM\Column(name="date")
     */
    
    
    protected $date;
    

    /**
    * @ORM\ManyToMany(targetEntity="\Mainsite\Entity\Tag", inversedBy="articles")
    * @ORM\JoinTable(name="articles_tag",
    *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
    *      )

     */

    protected $tags;

    /**
     * Constructor.
     */


    public function __construct()
    {
        
        $this->tags = new ArrayCollection();
     
    }

    /**
     * Returns ID of this post.
     * @return integer
     */
    public function getId() 
    {
        return $this->id;
    }

    /**
     * Sets ID of this post.
     * @param int $id
     */
    public function setId($id) 
    {
        $this->id = $id;
    }

    /**
     * Returns title.
     * @return string
     */
    public function getTitle() 
    {
        return $this->title;
    }

    /**
     * Sets title.
     * @param string $title
     */
    public function setTitle($title) 
    {
        $this->title = $title;
    }

    /**
     * Returns naam.
     * @return string
     */
    public function getNaam() 
    {
        return $this->naam;
    }

    /**
     * Sets naam.
     * @param string $title
     */
    public function setNaam($naam) 
    {
        $this->naam = $naam;
    }
    /**
     * Returns articles content.
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets post content.
     * @param type $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    /**
     * Returns navigation.
     * @return integer
     */
    public function getNavigation() 
    {
        return $this->navigation;
    }

    /**
     * Sets status.
     * @param integer $navigation
     */
    public function setNavigation($navigation) 
    {
        $this->navigation = $navigation;
    }   
    
    /**
     * Returns order.
     * @return integer
     */
    public function getOrder() 
    {
        return $this->order;
    }

    /**
     * Sets status.
     * @param integer $order
     */
    public function setOrder($order) 
    {
        $this->order = $order;
    }   
    /**
     * Returns order.
     * @return integer
     */
    public function getStatus() 
    {
        return $this->status;
    }

    /**
     * Sets status.
     * @param integer $order
     */
    public function setStatus($order) 
    {
        $this->status = $status;
    }   
/**
     * Returns order.
     * @return string
     */
    public function getAutor() 
    {
        return $this->autor;
    }

    /**
     * Sets status.
     * @param string $order
     */
    public function setAutor($autor) 
    {
        $this->autor = $autor;
    }   

    /**
     * Returns the date when this post was created.
     * @return string
     */
    public function getDateCreated() 
    {
        return $this->date;
    }
    
    /**
     * Sets the date when this post was created.
     * @param string $dateCreated
     */
    public function setDateCreated($dateCreated) 
    {
        $this->date = $date;
    }
    /**
     * Returns tags for this post.
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Adds a new tag to this post.
     * @param $tag
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * Removes association between this post and the given tag.
     * @param type $tag
     */
    public function removeTagAssociation($tag)
    {
        $this->tags->removeElement($tag);
    }
   
}
