<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="nameUrl", type="string", length=30)
     */
    private $nameUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="productQuantity", type="integer")
     */
    private $productQuantity;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $category;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="product", cascade={"All"})
     */
    private $images;
    
    /**
     * @ORM\OneToMany(targetEntity="Item_Order", mappedBy="product", cascade={"All"})
     */
    private $itemOrders;
    
    public function __construct() 
    {
        $this->itemOrders = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Product
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
     * Set nameUrl
     *
     * @param string $nameUrl
     *
     * @return Product
     */
    public function setNameUrl($nameUrl)
    {
        $this->nameUrl = $nameUrl;

        return $this;
    }

    /**
     * Get nameUrl
     *
     * @return string
     */
    public function getNameUrl()
    {
        return $this->nameUrl;
    } 

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
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
     * Set productQuantity
     *
     * @param integer $productQuantity
     *
     * @return Product
     */
    public function setProductQuantity($productQuantity)
    {
        $this->productQuantity = $productQuantity;

        return $this;
    }

    /**
     * Get productQuantity
     *
     * @return integer
     */
    public function getProductQuantity()
    {
        return $this->productQuantity;
    }   
    
    /**
     * Set category to product
     * 
     * @param \AppBundle\Entity\Category $category
     * @return \AppBundle\Entity\Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null) 
    {        
        $this->category = $category;
        
        return $this;
    }
    
    /**
     * Get category
     * 
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    public function getImages(){
        
        return $this->images;
    }
    
    /**
     * Add item order into itemOrders collection
     * 
     * @param \AppBundle\Entity\Item_Order $itemOrder
     * @return \AppBundle\Entity\Product
     */
    public function setItemOrder(\AppBundle\Entity\Item_Order $itemOrder)
    {
        $itemOrder->setProduct($this);
        $this->itemOrders[] = $itemOrder;
        
        return $this;
    }

    /**
     * Get item orders
     * 
     * @return \AppBundle\Entity\Item_Order
     */
    public function getItemOrders()
    {        
        return $this->itemOrders;
    }
    
    public function __toString()
    {        
        return $this->getName();
    }
}

