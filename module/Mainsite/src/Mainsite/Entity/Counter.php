<?php
namespace Mainsite\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a single post in a blog.
 * @ORM\Entity(repositoryClass="\Mainsite\Repository\BoxesRepository")
 * @ORM\Table(name="counter")
 */
class Counter
{
 
    protected $id;
    /**
     * @ORM\Id
     * @ORM\Column(name="counter")
     * @ORM\GeneratedValue
     */
    protected $value;

    /**
     * Constructor.
     */
    public function __construct() 
    {
        $value = $this->value; 
        
    }

        /**
     * Returns value.
     * @return string
     */
    public function getCounter()
    {
        return $this->value;
    }

    /**
     * Sets value.
     * @param string $value
     */
    public function setCounter($counter)
    {
        $this->value = $value;
    }

}

