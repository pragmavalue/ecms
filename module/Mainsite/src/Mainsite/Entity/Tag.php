<?php
namespace Mainsite\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a tag.
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag 
{
     // Post status constants.
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** 
     * @ORM\Column(name="naam") 
     */
    protected $naam;

    /**
     * @ORM\ManyToMany(targetEntity="\Mainsite\Entity\Articles", mappedBy="tags")
     */
    protected $articles;
    
    /**
     * Constructor.
     */
    public function __construct() 
    {        
        $this->articles = new ArrayCollection();
    }

    /**
     * Returns ID of this tag.
     * @return integer
     */
    public function getId() 
    {
        return $this->id;
    }

    /**
     * Sets ID of this tag.
     * @param int $id
     */
    public function setId($id) 
    {
        $this->id = $id;
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
     * @param string $naam
     */
    public function setNaam($naam) 
    {
        $this->naam = $naam;
    }
    
    /**
     * Returns posts which have this tag.
     * @return type
     */
    public function getArticles()
    {
        return $this->articles;
    }
    
    /**
     * Adds a post which has this tag.
     * @param type $post
     */
    public function addArticles($articles)
    {
        $this->articles[] = $articles;        
    }
}

