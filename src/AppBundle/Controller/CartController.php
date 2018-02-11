<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User_Not_Registered;
use AppBundle\Entity\User;
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
     * @Route("/", name="cart")
     * @Method("GET")
     */
    public function cartAction(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $em = $this->getDoctrine()->getManager();
        
        if (false === $authChecker->isGranted('ROLE_ADMIN')) {
            
            $user = $em->getRepository('AppBundle:User_Not_Registered')->findOneBy(array('clientIp' => $request->getClientIp()));
            
            if (null === $user) {
                
                $order = null;
                
            } else {
                
                $order = $em->getRepository('AppBundle:Orders')->findOneBy(array('notRegisteredOwner' => $user->getId(), 'status' => 1));
            }          
        
        } elseif (true === $authChecker->isGranted('ROLE_ADMIN')) {
            
            $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $user = $em->getRepository('AppBundle:User')->find($userId);
            
            $order = $em->getRepository('AppBundle:Orders')->findOneBy(array('registeredOwner' => $user->getId(), 'status' => 1));
        }
        
        return $this->render('cart/cart.html.twig', [
            'order' => $order
        ]);
    }
    
    /**
     * Cart confirm
     *
     * @Route("/confirm", name="cart_confirm")
     * @Method({"GET", "POST"})
     */
    public function cartConfirmAction(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $em = $this->getDoctrine()->getManager();
        
        $user = $this->loadUser($request, $authChecker, $em);
        
        $order = $this->loadOrder($user, $em);
        
        if ($order->getNotRegisteredOwner() && $user->getEmail() === null) {
            
            if ($request->get('email')) {
                
                    // add email vaidation in entity
                
                $user->setEmail($request->get('email'));
                
                $em->persist($user);
                $em->flush();
                
                return $this->redirectToRoute('order_create'); 
            }
            
            return $this->render('cart/cart-confirm.html.twig');
        } 
        
        return $this->redirectToRoute('order_create');       
    }

    /**
     * Add product to cart order
     * 
     * @Route("/add/{productId}", name="cart_add")
     * @Method({"GET", "POST"})
     */
    public function addProductToCartOrder(Request $request, AuthorizationCheckerInterface $authChecker, $productId)
    {       
        $em = $this->getDoctrine()->getManager();
        
        $user = $this->prepareUser($request, $authChecker, $em);
        
        $order = $this->prepareOrder($user, $em);
        
        $this->addProductToOrder($productId, $order, $em);
        
        $em->refresh($order);
        
        $order->countTotalPrice();
        
        $em->persist($order);
        $em->flush();

        return $this->redirectToRoute('cart');
    }
    
    /**
     * Remove product from cart order
     * 
     * @Route("/remove/{productId}", name="cart_remove")
     * @Method({"GET", "POST"})
     */
    public function removeProductFromCartOrder(Request $request, AuthorizationCheckerInterface $authChecker, $productId)
    {
        $em = $this->getDoctrine()->getManager();
        
        $user = $this->loadUser($request, $authChecker, $em);
        
        $order = $this->loadOrder($user, $em);
        
        $this->removeProductFromOrder($productId, $order, $em);  
        
        $em->refresh($order);
        
        $order->countTotalPrice();
        
        $em->persist($order);
        $em->flush();

        return $this->redirectToRoute('cart');
    }

    private function prepareUser($request, $authChecker, $em)
    {
        if (false === $authChecker->isGranted('ROLE_ADMIN')) {

            $user = $em->getRepository('AppBundle:User_Not_Registered')->findOneBy(array('clientIp' => $request->getClientIp()));
            
            if (null === $user) {
                
                $user = new User_Not_Registered();
                $user->setClientIp($request->getClientIp());
                
                $em->persist($user);
                $em->flush();
            }
            
        } elseif (true === $authChecker->isGranted('ROLE_ADMIN')) {
            
            $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $user = $em->getRepository('AppBundle:User')->find($userId);
        }
        
        return $user;
    }

    private function prepareOrder($user, $em)
    {                        
        if ($user instanceof User_Not_Registered) { 
            
            $order = $em->getRepository('AppBundle:Orders')->findOneBy(array('notRegisteredOwner' => $user->getId(), 'status' => 1));
            
            if (!is_object($order)){
                
                $order = new Orders();
                $order->setNotRegisteredOwner($user);
                $order->setStatus(1);

                $em->persist($order);
                $em->flush();               
            }
            
        } elseif ($user instanceof User) {

            $order = $em->getRepository('AppBundle:Orders')->findOneBy(array('registeredOwner' => $user->getId(), 'status' => 1));
            
            if (!is_object($order)) {
                
                $order = new Orders();
                $order->setRegisteredOwner($user);
                $order->setStatus(1);
                
                $em->persist($order);
                $em->flush(); 
            }
        }
      
        return $order;
    }
    
    private function addProductToOrder($productId, $order, $em)
    {              
        $product = $em->getRepository('AppBundle:Product')->find($productId);
        
        if ($order->getItemProductFromCollection($product)) {
            
            $itemOrder = $order->getItemProductFromCollection($product);
            
            $itemOrder->setQuantity($itemOrder->getQuantity() + 1);
            $itemOrder->setPrice($product);
            
        } else {
            
            $itemOrder = new Item_Order();
            $itemOrder->setProduct($product);
            $itemOrder->setQuantity(1);
            $itemOrder->setPrice($product);
            $itemOrder->setOrder($order);
        }
        
        $em->persist($itemOrder);
        $em->flush();
        
        return true;
    }
    
    private function loadUser($request, $authChecker, $em)
    {
        if (false === $authChecker->isGranted('ROLE_ADMIN')) {

            $user = $em->getRepository('AppBundle:User_Not_Registered')->findOneBy(array('clientIp' => $request->getClientIp()));
            
            if (null === $user) {
                
                var_dump('throw exception in a future');die;
            }
            
        } elseif (true === $authChecker->isGranted('ROLE_ADMIN')) {
            
            $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $user = $em->getRepository('AppBundle:User')->find($userId);
            
            if (null === $user) {
                
                var_dump('throw exception in a future');die;
            }
        }
        
        return $user;
    }
    
    private function loadOrder($user, $em)
    {                        
        if ($user instanceof User_Not_Registered) { 
            
            $order = $em->getRepository('AppBundle:Orders')->findOneBy(array('notRegisteredOwner' => $user->getId(), 'status' => 1));
            
            if (!is_object($order)){
                
                var_dump('throw exception in a future');die;               
            }
            
        } elseif ($user instanceof User) {

            $order = $em->getRepository('AppBundle:Orders')->findOneBy(array('registeredOwner' => $user->getId(), 'status' => 1));
            
            if (!is_object($order)) {
                
                var_dump('throw exception in a future');die;
            }
        }
      
        return $order;
    }
    
    private function removeProductFromOrder($productId, $order, $em)
    {
        $product = $em->getRepository('AppBundle:Product')->find($productId);
        
        if ($order->getItemProductFromCollection($product)) {
            
            $itemOrder = $order->getItemProductFromCollection($product);
            
            if (!$itemOrder instanceof Item_Order) {
                
               var_dump('throw exception in a future (object is not instance of Item_Order)');die;
            }
            
        } else {
            
            var_dump('throw exception in a future (there is no Item_Order in DB)');die;
        }

        $em->remove($itemOrder);
        $em->flush();
        
        return true;
    }
}
