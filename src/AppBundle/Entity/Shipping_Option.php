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
     * @ORM\OneToMany(targetEntity="Address", mappedBy="shippingOption", cascade={"persist"}) 
     */
    private $addresses;

    public function __construct() 
    {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString(){

        return $this->getName();
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
     * Add address to shippingOption collection
     * 
     * @param \AppBundle\Entity\Address $address
     * @return \AppBundle\Entity\Shipping_Option
     */
    public function setAddress(\AppBundle\Entity\Address $address)
    {
        $address->setShippingOption($this);
        $this->addresses[] = $address;
        
        return $this;
    }
    
    /**
     * Get addresses
     * 
     * @return type
     */
    public function getAddresses()
    {
        $expression = Criteria::expr()
            ->eq('shippingOption', $this)
        ;
        
        $criteria = Criteria::create()
            ->where($expression)
        ;
        
        return $this->addresses->matching($criteria)->getValues();
    }
}

