<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product_Order
 *
 * @ORM\Table(name="product_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product_OrderRepository")
 */
class Product_Order
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
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
    
    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productOrders")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;
    
    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="products")
     * @ORM\JoinColumn(name="orders_id", referencedColumnName="id", nullable=false)
     */
    private $productOrder;

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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product_Order
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product_Order
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
    
    public function setProduct($product) {
        
        $this->product = $product;
        
        return $this;
    }
    
    public function getProduct(){
        
        return $this->product;
    }
    
    public function setProductOrder($productOrder) {
        
        $this->productOrder= $productOrder;
        
        return $this;
    }
    
    public function getProductOrder(){
        
        return $this->productOrder;
    }
}

