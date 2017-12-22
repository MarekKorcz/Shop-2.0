<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * Lists all user entities.
     * 
     * ADMIN
     *
     * @Route("/customers", name="customers")
     * @Method("GET")
     */
    public function customersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('admin/customers.html.twig', array(
            'users' => $users,
        ));
    }
}
