<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AddressRepository")
 */
class Address
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
     * @var int
     *
     * @ORM\Column(name="phoneNumber", type="string", length=15)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=50)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="streetNumber", type="string", length=20)
     */
    private $streetNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="houseNumber", type="string", length=10)
     */
    private $houseNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="postCode", type="string", length=10)
     */
    private $postCode;  
    
    /**
     * @ORM\ManyToOne(targetEntity="Shipping_Option", inversedBy="addresses")
     * @ORM\JoinColumn(name="shipping_option_id", referencedColumnName="id")
     */
    private $shippingOption;
    
    /**
     * @ORM\OneToOne(targetEntity="Orders", inversedBy="address")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;


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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Address
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set streetNumber
     *
     * @param string $streetNumber
     *
     * @return Address
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    /**
     * Get streetNumber
     *
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * Set houseNumber
     *
     * @param string $houseNumber
     *
     * @return Address
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return string
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postCode
     *
     * @param string $postCode
     *
     * @return Address
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }
    
    /**
     * Set shippingOption to address
     *
     * @param \AppBundle\Entity\Shipping_Option $shippingOption
     * @return \AppBundle\Entity\Address
     */
    public function setShippingOption(\AppBundle\Entity\Shipping_Option $shippingOption = null)
    {
        $this->shippingOption = $shippingOption;

        return $this;
    }

    /**
     * Get shippingOption
     * 
     * @return type
     */
    public function getShippingOption()
    {
        return $this->shippingOption;
    }
    
    /**
     * Set order to address
     * 
     * @param \AppBundle\Entity\Orders $order
     * @return \AppBundle\Entity\Address
     */
    public function setOrder(\AppBundle\Entity\Orders $order = null) 
    {        
        $this->order = $order;
        
        return $this;
    }
    
    /**
     * Get order
     * 
     * @return \AppBundle\Entity\Orders
     */
    public function getOrder()
    {
        return $this->order;
    }
}

