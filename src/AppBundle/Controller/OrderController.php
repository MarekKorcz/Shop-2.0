<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\User;
use AppBundle\Entity\User_Not_Registered;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Order controller.
 *
 * @Route("order")
 */
class OrderController extends Controller
{
    /**
     * Create order
     * 
     * @Route("/create", name="order_create")
     * @Method({"GET", "POST"})
     */
    public function createOrderAction(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $address = new Address();
        $form = $this->createForm('AppBundle\Form\AddressType', $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
        
            $user = $this->loadUser($request, $authChecker, $em);
            
            $order = $this->loadOrder($user, $em);
            
            $order->setAddress($address);
            
            $em->persist($order);
            $em->flush();

            return $this->redirectToRoute('order_success');
        }
        
        return $this->render('order/create.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Success order page
     * 
     * @Route("/success", name="order_success")
     * @Method({"GET", "POST"})
     */
    public function successOrderAction()
    {
        var_dump('Congrats! You did it!');die;
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
}
