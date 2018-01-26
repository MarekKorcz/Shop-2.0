<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=40)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nameUrl", type="string", length=40)
     */
    private $nameUrl;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category", cascade={"All"})
     */
    private $products;
    
    public function __construct() 
    {
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * @return Category
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
     * Add product to category collection
     * 
     * @param \AppBundle\Entity\Product $product
     * @return \AppBundle\Entity\Category
     */
    public function setProduct(\AppBundle\Entity\Product $product)
    {
        $product->setCategory($this);
        $this->products[] = $product;
        
        return $this;
    }
    
    /**
     * Get product
     * 
     * @return \AppBundle\Entity\Product
     */
    public function getProducts()
    {        
        return $this->products;
    }
    
    public function __toString(){

        return $this->getName();
    }
}

