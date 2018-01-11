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
    
    public function getOrders()
    {        
        return $this->orders;
    }
}

