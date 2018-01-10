<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{    
    /**
     * Creates a new product entity.
     * 
     * @Route("/product/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('AppBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('nameUrl' => $product->getNameUrl()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }
    
        /**
     * Displays a form to edit an existing product entity.
     * 
     * @Route("/product/{nameUrl}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editProductAction(Request $request, Product $product)
    {
        $deleteForm = $this->createProductDeleteForm($product);
        $editForm = $this->createForm('AppBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit', array('nameUrl' => $product->getNameUrl()));
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Lists of all product entities.
     * 
     * @Route("/product/list", name="product_list")
     * @Method("GET")
     */
    public function listProductsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAll();

        return $this->render('product/list.html.twig', array(
            'products' => $products,
        ));
    }
    
    /**
     * Deletes a product entity.
     *
     * @Route("/product/{nameUrl}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteProductAction(Request $request, Product $product)
    {
        $form = $this->createProductDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_list');
    }
    
    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createProductDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('nameUrl' => $product->getNameUrl())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
    
    /**
     * Lists all users.
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