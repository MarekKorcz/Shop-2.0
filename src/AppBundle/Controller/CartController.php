<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


/**
 * Cart controller.
 *
 * @Route("cart")
 */
class CartController extends Controller
{
    /**
     * List of products in cart
     *
     * @Route("/", name="cart_list")
     * @Method("GET")
     */
    public function cartAction()
    {
        // cart logic
        
        return $this->render('cart/cart.html.twig');
    }
    
    /**
     * Cart confirm
     *
     * @Route("/confirm", name="cart_confirm")
     * @Method("GET")
     */
    public function cartConfirmAction()
    {
        // cart summary
        
        return $this->render('cart/cart-confirm.html.twig');
    }
}
