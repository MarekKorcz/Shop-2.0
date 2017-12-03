<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Finalized_Order
 *
 * @ORM\Table(name="finalized_orders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Finalized_OrdersRepository")
 */
class Finalized_Orders
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
     * @var string
     *
     * @ORM\Column(name="shippingOption", type="string", length=50)
     */
    private $shippingOption;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="finalizedOrders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $owner;


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
     * @return Finalized_Order
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
     * @return Finalized_Order
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
     * Set shippingOption
     *
     * @param string $shippingOption
     *
     * @return Finalized_Order
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
    
    public function setOwner($owner) {
        
        $this->owner = $owner;
        
        return $this;
    }
    
    public function getOwner(){
        
        return $this->owner;
    }
}

