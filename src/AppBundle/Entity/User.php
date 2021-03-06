<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=15)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=25)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30)
     */
    private $email;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="password", type="string", length=60)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastLog", type="datetime")
     */
    private $lastLog;
    
    /**
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\OneToMany(targetEntity="Orders", mappedBy="registeredOwner", cascade={"All"})
     */
    private $orders;
    
    public function __construct() 
    {        
        $this->creationDate = new \DateTime();
        $this->isActive = true;
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
   /**
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        // add email vaidation
        
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    // needed for UserInterface
    public function getUsername() 
    {
        $this->getEmail();
    }
    
    public function getSalt()
    {
        return null;
    }
    
    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    public function eraseCredentials()
    {
    }
    
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
        ) = unserialize($serialized);
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastLog
     *
     * @param \DateTime $lastLog
     *
     * @return User
     */
    public function setLastLog($lastLog)
    {
        $this->lastLog = $lastLog;

        return $this;
    }

    /**
     * Get lastLog
     *
     * @return \DateTime
     */
    public function getLastLog()
    {
        return $this->lastLog;
    }
    
    /**
     * Get isActive
     * 
     * @param boolean $isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    /**
     * Add order to orders collection
     * 
     * @param \AppBundle\Entity\Orders $order
     * @return \AppBundle\Entity\User
     */
    public function setOrder(\AppBundle\Entity\Orders $order)
    {
        $order->setRegisteredOwner($this);
        $this->orders[] = $order;
        
        return $this;
    }

    /**
     * Get orders
     * 
     * @return \AppBundle\Entity\Orders
     */
    public function getOrders()
    {        
        return $this->orders;
    }
}
