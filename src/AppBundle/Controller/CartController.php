<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


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
    
    /**
     * Add product to cart
     * 
     * @Route("/add/{productId}", name="cart_add")
     * @Method({"GET", "POST"})
     */
    public function addProductToCart(Request $request, AuthorizationCheckerInterface $authChecker, $productId)
    {
        
        if (false === $authChecker->isGranted('ROLE_ADMIN')) {

            $clientIp = $request->getClientIp();
            
            $this->continueAsNotRegistered($productId, $clientIp);
            
        } elseif (true === $authChecker->isGranted('ROLE_ADMIN')) {

            $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            
            $this->continueAsRegistered($productId, $userId);
        }
    }
    
    private function continueAsNotRegistered($productId, $clientIp)
    {
        var_dump('Product id: '.$productId.', Client ip address: '.$clientIp);die;
    }
    
    private function continueAsRegistered($productId, $userId)
    {
        var_dump('Product id: '.$productId.', User id: '.$userId);die;
    }
}
