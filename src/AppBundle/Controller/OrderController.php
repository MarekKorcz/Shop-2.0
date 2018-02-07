<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
    public function createOrderAction()
    {
        var_dump('order creation in progress');die;
    }
}
