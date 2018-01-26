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
     * @ORM\Column(name="price", type="float", nullable=true)
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
     * @ORM\Column(name="shippingOption", type="string", length=50, nullable=true)
     */
    private $shippingOption;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="implementationState", type="string", length=30, nullable=true)
     */
    private $implementationState;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="registered_user_id", referencedColumnName="id")
     */
    private $registeredOwner;
    
    /**
     * @ORM\ManyToOne(targetEntity="User_Not_Registered", inversedBy="orders")
     * @ORM\JoinColumn(name="user_not_registered_id", referencedColumnName="id")
     */
    private $notRegisteredOwner;

    /**
     * @ORM\OneToMany(targetEntity="Item_Order", mappedBy="order", cascade={"All"})
     */
    private $products;
    
    /**
     * @ORM\OneToOne(targetEntity="Address", mappedBy="order")
     */
    private $address;
    
    public function __construct() 
    {     
        $this->creationDate = new \DateTime();
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    public function setRegisteredOwner($registeredOwner) 
    {        
        $this->registeredOwner = $registeredOwner;
        
        return $this;
    }
    
    public function getRegisteredOwner()
    {        
        return $this->registeredOwner;
    }
    
    public function setNotRegisteredOwner($notRegisteredOwner) 
    {        
        $this->notRegisteredOwner = $notRegisteredOwner;
        
        return $this;
    }
    
    public function getNotRegisteredOwner()
    {        
        return $this->notRegisteredOwner;
    }
    
    /**
     * Set product item to order
     * 
     * @param \AppBundle\Entity\Item_Order $itemOrder
     * @return \AppBundle\Entity\Orders
     */
    public function setProduct(\AppBundle\Entity\Item_Order $itemOrder)
    {
        $itemOrder->setOrder($this);
        $this->products[] = $itemOrder;
        
        return $this;
    }

    /**
     * Get item products
     * 
     * @return \AppBundle\Entity\Item_Order
     */
    public function getProducts(){
        
        return $this->products;
    }
    
    public function setAddress($address) {
        
        $this->address = $address;
        
        return $this;
    }
    
    public function getAddress(){
        
        return $this->address;
    }
}

