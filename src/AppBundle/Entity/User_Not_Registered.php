<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User_Not_Registered
 *
 * @ORM\Table(name="user_not_registered")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User_Not_RegisteredRepository")
 */
class User_Not_Registered
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
     * @ORM\Column(name="clientIp", type="string", length=45)
     */
    private $clientIp;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=true)
     */
    private $email;
    
    /**
     * @ORM\OneToMany(targetEntity="Orders", mappedBy="notRegisteredOwner", cascade={"All"})
     */
    private $orders;

    public function __construct() 
    {
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
     * Set clientIp
     *
     * @param string $clientIp
     *
     * @return User_Not_Registered
     */
    public function setClientIp($clientIp)
    {
        $this->clientIp = $clientIp;

        return $this;
    }

    /**
     * Get clientIp
     *
     * @return string
     */
    public function getClientIp()
    {
        return $this->clientIp;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User_Not_Registered
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
     * Set order to orders collection
     * 
     * @param \AppBundle\Entity\Orders $order
     * @return \AppBundle\Entity\User_Not_Registered
     */
    public function setOrder(\AppBundle\Entity\Orders $order)
    {
        $order->setNotRegisteredOwner($this);
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

