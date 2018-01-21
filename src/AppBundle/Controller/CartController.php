<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\User_Not_Registered;
use AppBundle\Entity\Orders;
use AppBundle\Entity\Item_Order;
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
     * Add product to cart order
     * 
     * @Route("/add/{product}", name="cart_add")
     * @Method({"GET", "POST"})
     */
    public function addProductToCartOrder(Request $request, AuthorizationCheckerInterface $authChecker, $product)
    {
        if (false === $authChecker->isGranted('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User_Not_Registered')->findNotRegisteredUserByIpAddress($request->getClientIp());
            
            if (null === $user) {
                
                $user = new User_Not_Registered();
                $user->setClientIp($request->getClientIp());
                
                $em->persist($user);
                $em->flush();

                $order = $this->prepareOrder($user);
                
                var_dump('under construction (not_registered)');die;
                
    //            $this->addProductToOrder($product, $order);
            }
                        
            $order = $this->prepareOrder($user);
            
            var_dump('under construction (not_registered)');die;
            
//            $this->addProductToOrder($product, $order);
            
        } elseif (true === $authChecker->isGranted('ROLE_ADMIN')) {
            
            $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
            
            $order = $this->prepareOrder($user);
            
            var_dump('under construction (registered)');die;
            
//            $this->addProductToOrder($product, $order);
        }
        
        return null;
    }
    
    private function prepareOrder($user)
    {                
        $em = $this->getDoctrine()->getManager();
        
        if ($user instanceof User_Not_Registered) { 
            
            $order = $em->getRepository('AppBundle:Orders')->findCartOrderByNotRegisteredUserId($user->getId());
            
            if (is_object($order)){
                   
                return $order;
                
            } else {
                                
                $order = new Orders();
                $order->setNotRegisteredOwner($user);
                $order->setStatus(1);
                
                return $order;
            }
            
        } else {
        
            $order = $em->getRepository('AppBundle:Orders')->findCartOrderByRegisteredUserId($user);
            
            if (is_object($order)) {
                
                return $order;
                
            } else {
                
                $order = new Orders();
                $order->setRegisteredOwner($user);
                $order->setStatus(1);
                
                return $order;
            }
        }
      
        return null;
    }
    
    private function addProductToOrder($product, $order) 
    {
        
    }
}
