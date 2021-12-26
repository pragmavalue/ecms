<?php
namespace Mainsite\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @ORM\Entity(repositoryClass="\Mainsite\Repository\BoxesRepository")
 * @ORM\Table(name="boxes")
 */
class Boxes
{

    /**
      * @ORM\Id
      * @ORM\Column(name="id")
      * @ORM\GeneratedValue
     */
    
    protected $id;
    /**
     * @ORM\Column(name="Box1")
     * @ORM\GeneratedValue
     */
    protected $Box1;

    /**
     * @ORM\Column(name="Box2")
     * @ORM\GeneratedValue
     */
    protected $Box2;
    /**
     * @ORM\Column(name="Box3")
     * @ORM\GeneratedValue
     */
    protected $Box3;

    /**
     * Returns counter.
     * @return string
     */
    public function getBox1() 
    {
        return $this->Box1;
    }

    /**
     * Sets counter.
     * @param string $title
     */
    public function setBox1($Box1) 
    {
        $this->Box1 = $Box1;
    }

    /**
     * Returns counter.
     * @return string
     */
    public function getBox2() 
    {
        return $this->Box2;
    }

    /**
     * Sets counter.
     * @param string $title
     */
    public function setBox2($Box2) 
    {
        $this->Box2 = $Box2;
    }
    
    /**
     * Returns counter.
     * @return string
     */
    public function getBox3() 
    {
        return $this->Box3;
    }

    /**
     * Sets counter.
     * @param string $title
     */
    public function setBox3($Box3) 
    {
        $this->Box3 = $Box3;
    }


}

