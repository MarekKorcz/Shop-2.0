<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * Shipping_Option
 *
 * @ORM\Table(name="shipping_option")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Shipping_OptionRepository")
 */
class Shipping_Option
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
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
    
    /**
     * @ORM\OneToMany(targetEntity="Orders", mappedBy="shippingOption", cascade={"persist"}) 
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
     * Set name
     *
     * @param string $name
     *
     * @return ShippingOption
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
     * Set price
     *
     * @param float $price
     *
     * @return ShippingOption
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
     * Add order to shippingOption collection
     * 
     * @param \AppBundle\Entity\Orders $order
     * @return \AppBundle\Entity\Shipping_Option
     */
    public function setOrder(\AppBundle\Entity\Orders $order)
    {
        $order->setShippingOption($this);
        $this->orders[] = $order;
        
        return $this;
    }
    
    /**
     * Get orders
     * 
     * @return type
     */
    public function getOrder()
    {
        $expression = Criteria::expr()
            ->eq('shippingOption', $this)
        ;
        
        $criteria = Criteria::create()
            ->where($expression)
        ;
        
        return $this->orders->matching($criteria)->getValues();
    }
}

