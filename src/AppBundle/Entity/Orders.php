<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdersRepository")
 */
class Orders
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
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="shippingOption", type="string", length=50)
     */
    private $shippingOption;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="implementationState", type="string", length=30)
     */
    private $implementationState;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="Product_Order", mappedBy="productOrder", cascade={"All"})
     */
    private $products;

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
     * Set price
     *
     * @param float $price
     *
     * @return Orders
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Orders
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
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
     * Set status
     *
     * @param int $status
     *
     * @return Orders
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set shippingOption
     *
     * @param string $shippingOption
     *
     * @return Orders
     */
    public function setShippingOption($shippingOption)
    {
        $this->shippingOption = $shippingOption;

        return $this;
    }

    /**
     * Get shippingOption
     *
     * @return string
     */
    public function getShippingOption()
    {
        return $this->shippingOption;
    }
    
    /**
     * Set implementationState
     *
     * @param string $implementationState
     *
     * @return Orders
     */
    public function setImplementationState($implementationState)
    {
        $this->implementationState = $implementationState;

        return $this;
    }

    /**
     * Get implementationState
     *
     * @return string
     */
    public function getImplementationState()
    {
        return $this->implementationState;
    }
    
    public function setOwner($owner) {
        
        $this->owner = $owner;
        
        return $this;
    }
    
    public function getOwner(){
        
        return $this->owner;
    }
    
    public function getProducts(){
        
        return $this->products;
    }
}

