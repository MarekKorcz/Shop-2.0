<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $surname;
    
    /**
     * @ORM\OneToMany(targetEntity="UserOrder", mappedBy="user", cascade={"All"})
     */
    private $userOrders;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user", cascade={"All"})
     */
    private $comments;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUserName()
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUserSurname()
    {
        return $this->surname;
    }
    
    public function getUserOrders(){
        
        return $this->userOrders;
    }
    
    public function getComments(){
        
        return $this->comments;
    }
    
    public function __toString(){
        
        return $this->getUserName();
    }
    
    public function __construct(){
        
        parent:: __construct();
        
        $this->userOrders = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }
}