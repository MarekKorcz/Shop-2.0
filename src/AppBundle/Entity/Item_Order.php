<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * Item_Order
 *
 * @ORM\Table(name="item_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Item_OrderRepository")
 */
class Item_Order
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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="itemOrders")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;
    
    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="products")
     * @ORM\JoinColumn(name="orders_id", referencedColumnName="id", nullable=false)
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Item_Order
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
     * @param Product $product
     *
     * @return Item_Order
     */
    public function setPrice(Product $product)
    {
        $this->price = $product->getPrice() * $this->getQuantity();

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
    
    public function setOrder($order) {
        
        $this->order= $order;
        
        return $this;
    }
    
    public function getOrder(){
        
        return $this->order;
    }
}

