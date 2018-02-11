<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Criteria;
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
     * @ORM\Column(name="totalPrice", type="float", nullable=true)
     */
    private $totalPrice;

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
     * @ORM\OneToOne(targetEntity="Address", mappedBy="order", cascade={"persist"})
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
     * Summarize prices of all items in collection and assign the equator to totalPrice
     * 
     * @return \AppBundle\Entity\Orders
     */
    public function countTotalPrice()
    {
        $sum = 0;
        
        foreach ($this->getProducts() as $item) {
            
            $sum += $item->getPrice();
        }
        
        $this->totalPrice = $sum;
        
        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
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
    
    /**
     * Set registered user to order
     * 
     * @param \AppBundle\Entity\User $registeredOwner
     * @return \AppBundle\Entity\Orders
     */
    public function setRegisteredOwner(\AppBundle\Entity\User $registeredOwner = null) 
    {        
        $this->registeredOwner = $registeredOwner;
        
        return $this;
    }
    
    /**
     * Get registered user
     * 
     * @return \AppBundle\Entity\User
     */
    public function getRegisteredOwner()
    {        
        return $this->registeredOwner;
    }
    
    /**
     * Set not registered user to order
     * 
     * @param \AppBundle\Entity\User_Not_Registered $notRegisteredOwner
     * @return \AppBundle\Entity\Orders
     */
    public function setNotRegisteredOwner(\AppBundle\Entity\User_Not_Registered $notRegisteredOwner = null) 
    {        
        $this->notRegisteredOwner = $notRegisteredOwner;
        
        return $this;
    }
    
    /**
     * Get not registered user
     * 
     * @return \AppBundle\Entity\User_Not_Registered
     */
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
     * @return type
     */
    public function getProducts()
    {        
        $expression = Criteria::expr()
                ->eq("order", $this)
        ;
        
        $criteria = Criteria::create()
            ->where($expression)
        ;
        
        return $this->products->matching($criteria)->getValues();
    }
    
    /**
     * Set addres to order
     * 
     * @param \AppBundle\Entity\Address $address
     * @return \AppBundle\Entity\Orders
     */
    public function setAddress(\AppBundle\Entity\Address $address) 
    {        
        $address->setOrder($this);
        $this->address = $address;
        
        return $this;
    }
    
    /**
     * Get address
     * 
     * @return \AppBundle\Entity\Address
     */
    public function getAddress()
    {        
        return $this->address;
    }
    
    /**
     * Display item product in order's product item collection
     * 
     * @param \AppBundle\Entity\Product $product
     * @return type
     */
    public function getItemProductFromCollection(Product $product)
    {
        $expression = Criteria::expr()
                ->eq("product", $product)
        ;
        
        $criteria = Criteria::create()
            ->where($expression)
        ;

        $productItem = $this->products->matching($criteria);

        if (is_object($productItem->first()) && $productItem->first() === $productItem->last()) {
            
            return $productItem->first();
            
        } elseif (false === $productItem->first() && $productItem->last()) {
            
            return null;
        }
    }
}

